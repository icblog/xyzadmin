<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\DepartmentAndCompany;
use App\Models\User;



class UserController extends BaseController
{

  //METHODS USED FROM HELPER TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
  //returnGenericSystemErrMsg

  //METHODS USED FROM TOKEN TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
  //genarateToken

  public function addUserIndex(Request $request)
  {
    return Inertia::render('user/AddUser');
  } // end addUserIndex

  public function addCoworkerIndex()
  {

    $departmentResult = DepartmentAndCompany::fetchDepartmentsAndCompanies("is_depart_or_comp", 0, "=", false);

    if ($departmentResult['error']) {
      return redirect()
        ->route('addcoworker.index')
        ->withErrors(["fail" => $this->returnGenericSystemErrMsg()])
        ->withInput();
    }
    return Inertia::render('user/AddCoworker', [
      'departmentRes' => $departmentResult['departmentResult'],

    ]);
  }

  public function addContractorIndex()
  {
    $departmentResult = DepartmentAndCompany::fetchDepartmentsAndCompanies("is_depart_or_comp", 0, "=", false);

    if ($departmentResult['error']) {
      return redirect()
        ->route('addcontractor.index')
        ->withErrors(["fail" => $this->returnGenericSystemErrMsg()])
        ->withInput();
    }
    return Inertia::render('user/AddContractor', [
      'departmentRes' => $departmentResult['departmentResult'],

    ]);
  }

  public function viewUsersIndex(Request $request)
  {

    $result_per_page = $this->returnResultPerPageNumber(); //Find this in base controller
    $option_selected = $request->has('option_selected') ? $request->option_selected : "";
    $searched_word = $request->has('searched_word') ? $request->searched_word : "";

    $view_user_res = User::viewUsers($option_selected, $searched_word, true, $result_per_page);

    if ($view_user_res['error']) {
      return redirect()
        ->route('viewusers.index')
        ->withErrors(["fail" => $this->returnGenericSystemErrMsg()])
        ->withInput();
    }
    // dd($view_user_res['view_users_data']);

    return Inertia::render('user/ViewUsers', [
      'view_users_res' => $view_user_res['view_users_data'],

    ]);
  } //end viewUsersIndex

  public function editUserIndex(Request $request)
  {

    $departmentResult = DepartmentAndCompany::fetchDepartmentsAndCompanies("is_depart_or_comp", 0, "=", false);

    if ($departmentResult['error']) {
      return redirect()
        ->route('adduser.index')
        ->withErrors(["fail" => $this->returnGenericSystemErrMsg()])
        ->withInput();
    }

    return Inertia::render('user/EditUser', [
      'departmentRes' => $departmentResult['departmentResult'],

    ]);
  } //end editUserIndex






  public function update(Request $request)
  {

    //Check if myhouse the hidden recaptcha input is filled in,
    //if that is the case redirect to home page.

    if ($request->myhouse != '') {
      return redirect()->route('home.index');
      die();
    }

    $niceNames = array(
      'first_name' => 'first name',
      'last_name' => 'last name'
    );

    $validator = Validator::make(
      $request->all(),
      [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|string|email',
        'phone' => 'required|string',
      ]
    );
    //set custom form input names
    $validator->setAttributeNames($niceNames);

    $validator->after(function ($validator) use ($request) {

      if (!$this->validatePhone($request->phone)) {
        $validator->errors()->add(
          'phone',
          'Phone is invalid'
        );
      }

      //check to ensure email is unique if it has been changed
      if ($request->email != '' && $request->email != $request->old_email) {
        $email_check = User::select('id')->where('email', $request->email)->first();
        if (!is_null($email_check)) {
          $validator->errors()->add(
            'email',
            'Email already exist, please enter a different one thank you.'
          );
        }
      }
    });

    //Check for validation errors
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors()->all(),
        'edit_user_01' => '01',
      ]);
      die();
    } //end if validation

    try {
      //No errors update DB user record
      $array_data = array(
        'fname' => $request->first_name,
        'lname' => $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'department' => $request->department_selected_id,
        'xyz_app_access' => $request->xyz_app_access,
        'role' => $request->user_role,
        'is_leader' => $request->leader,
        'updated_by' => Auth::user()->id,
        'what_was_change' => 'User details'
      );

      if ($request->old_app_access === 0 && $request->xyz_app_access === 1) {

        //Generate initial 8 random character password
        $password = $this->randomString(8);

        //add to update dada array
        $array_data['password'] = Hash::make($password);
        $array_data['using_system_pass'] = 'yes';

        $subject = "IC-admin Registration";
        $emailTemplate = "mail.reg-email-template";

        $sendLinkOutCome = $this->sendRegEmail($request->first_name, $request->username, $request->email, $password, $subject, $emailTemplate);

        if ($sendLinkOutCome["error"]) {
          return response()->json([
            'errors' => $this->returnGenericSystemErrMsg(),
            'error_code' => '04',
          ], 422);
        } //End if out come error
      } //end if

      User::where('id', $request->user_id)->update($array_data);

      return response()->json([
        'errors' => []
      ], 201);
    } catch (\Exception $e) {
      // dd($e);
      return response()->json([
        'errors' => $this->returnGenericSystemErrMsg(),
      ], 401);
    } // end try catch

  } // end update
  public function handleAddUser(Request $request)
  {
    //Check if myhouse the hidden recaptcha input is filled in,
    //if that is the case redirect to home page.

    if ($request->myhouse != '') {
      return redirect()->route('home.index');
      die();
    }
    if ($request->has('user_type')) {
      if ($request->user_type == "coworker") {
        $this->handleAddCoworker($request);
      } else if ($request->user_type == "contractor") {
        $this->handleAddContractor($request);
      } else {
        return redirect()->route('home.index');
        die();
      }
    } else {
      return redirect()->route('home.index');
      die();
    }
  }

  private function handleAddContractor($request)
  {


    $niceNames = array(
      'first_name' => 'first name',
      'last_name' => 'last name'
    );

    $validator = Validator::make(
      $request->all(),
      [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'badge' => 'required|string|unique:regular_contractors',
        'email' => 'required|string|email',
        'leader' => 'required',
        'departmentSelectedId' => 'required'
      ],
      [
        'departmentSelectedId.required' => 'Please select a department',
        'leader.required' => 'Please indicate if user is a leader'
      ]
    );
    //set custom form input names
    $validator->setAttributeNames($niceNames);

    $validator->after(function ($validator) use ($request) {
      if ($request->phone == "") {
        $validator->errors()->add(
          'phone',
          'The phone field is required'
        );
      }

      if ($request->phone != "") {
        if (!$this->validatePhone($request->phone)) {
          $validator->errors()->add(
            'phone',
            'Phone is invalid'
          );
        }
      }
    });

    //Check for validation errors
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors()->all(),
        'error_code' => '01',
      ]);
      die();
    } //end if validation

    //Check if departmentSelectedId is a number if not, redirect to homepage
    if (!is_numeric($request->departmentSelectedId)) {
      return redirect()->route('home.index');
      die();
    }


      try {
        $user = new User();
        $user->fname = $request->first_name;
        $user->lname = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->department = $request->departmentSelectedId;
        $user->uip = $request->ip();
        $user->xyz_app_access = $request->xyz_app_access;
        $user->is_leader = $request->leader;
        $user->created_by = Auth::user()->id;
        $user->save();

        return response()->json([
          'errors' => ''
        ], 201);
      } catch (\Exception $e) {
        // dd($e);
        return response()->json([
          'errors' => $this->returnGenericSystemErrMsg(),
          'error_code' => '06',
        ], 422);
      } // end try catch

    } //end if user is not null
  

  } // end method store


  private function handleAddCoworker($request){


    $niceNames = array(
      'first_name' => 'first name',
      'last_name' => 'last name'
    );

    $validator = Validator::make(
      $request->all(),
      [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|string|email',
        'xyz_app_access' => 'required',
        'leader' => 'required',
        'departmentSelectedId' => 'required'
      ],
      [
        'departmentSelectedId.required' => 'Please select a department',
        'xyz_app_access.required' => 'Please indicate if user should have access to xyz app',
        'leader.required' => 'Please indicate if user is a leader'
      ]
    );
    //set custom form input names
    $validator->setAttributeNames($niceNames);

    $validator->after(function ($validator) use ($request) {
      if ($request->phone == "") {
        $validator->errors()->add(
          'phone',
          'The phone field is required'
        );
      }

      if ($request->phone != "") {
        if (!$this->validatePhone($request->phone)) {
          $validator->errors()->add(
            'phone',
            'Phone is invalid'
          );
        }
      }
    });

    //Check for validation errors
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors()->all(),
        'error_code' => '01',
      ]);
      die();
    } //end if validation

    //Check if departmentSelectedId is a number if not, redirect to homepage
    if (!is_numeric($request->departmentSelectedId)) {
      return redirect()->route('home.index');
      die();
    }

    //Check if the user email has been registered already, if so send a link for them to reset their password.
    //Else save the user details into DB and send temp details for them to log in
    $userOutCome = User::checkIfUserExist('email', $request->email);
    //check if the user outcome is error, if so return generic system error
    if ($userOutCome["error"]) {
      return response()->json([
        'errors' => $this->returnGenericSystemErrMsg(),
        'error_code' => '02',
      ], 422);
    } //End if out come error

    $subject = "About your registration";

    if (!is_null($userOutCome["user"])) {
      //user is found send password reset link email
      //Generate token
      $tokenData = array('email' => $request->email);
      $token = $this->genarateToken($this->linkExpireTime, $tokenData);
      $emailTemplate = "mail.password-reset-template";
      $sendLinkOutCome = $this->sendAlinkToUser($token, $request->email, $subject, $emailTemplate);

      if ($sendLinkOutCome["error"]) {
        return response()->json([
          'errors' => $this->returnGenericSystemErrMsg(),
          'error_code' => '03',
        ], 422);
      } //End if out come error

      if ($sendLinkOutCome["outcome"]) {
        return response()->json([
          'errors' => ''
        ], 201);
      } //End if out come error


    } else {
      //user is not found save user and send login email
      //Generate a random username using 2 letter of firstname and 2 letters lastname and 2 random number

      if (strlen($request->first_name) > 2 && strlen($request->last_name) > 3) {
        $str = $request->first_name . " " . $request->last_name;
        $pos = strpos($str, " ");
        $username = $str[0] . $str[1] . $str[$pos + 1] . $str[$pos + 2] . $str[$pos + 3];
      } else {
        $username = $request->first_name . $request->last_name;
      }

      $username = strtolower($username . "_" . $this->randomNumber(2));

      //Generate initial 8 random character password
      $password = $this->randomString(8);

      //Store the user datails in database
      try {
        $user = new User();
        $user->fname = $request->first_name;
        $user->lname = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->department = $request->departmentSelectedId;
        $user->uip = $request->ip();
        $user->xyz_app_access = $request->xyz_app_access;
        $user->is_leader = $request->leader;
        $user->created_by = Auth::user()->id;
        $user->save();

        //Check if user should have access to xyz app before sending login info
        if ($request->xyz_app_access === 1) {

          $emailTemplate = "mail.reg-email-template";

          $sendLinkOutCome = $this->sendRegEmail($request->first_name, $username, $request->email, $password, $subject, $emailTemplate);

          if ($sendLinkOutCome["error"]) {
            return response()->json([
              'errors' => $this->returnGenericSystemErrMsg(),
              'error_code' => '04',
            ], 422);
          } //End if out come error

        } //end  $request->xyz_app_access === 1


        return response()->json([
          'errors' => ''
        ], 201);
      } catch (\Exception $e) {
        // dd($e);
        return response()->json([
          'errors' => $this->returnGenericSystemErrMsg(),
          'error_code' => '05',
        ], 422);
      } // end try catch

    } //end if user is not null

  } // end method store

  public function findUser(Request $request)
  {

    if (!is_string($request->searchedword)) {
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg()
      ]);
    } //End if error

    $userResult =  User::searchUser($request->searchedword, '');


    if ($userResult["error"]) {

      return response()->json([
        'error' => $this->returnGenericSystemErrMsg()
      ]);
    } //End if error


    return response()->json([
      'error' => "",
      'coWorkerResData' => $userResult["searchResult"]
    ]);
  } // end findUser


  public function findUserEdit(Request $request)
  {

    if (!is_string($request->searchedword)) {
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg()
      ]);
    } //End if error

    $userResult =  User::searchUser($request->searchedword, 'edit');


    if ($userResult["error"]) {

      return response()->json([
        'error' => $this->returnGenericSystemErrMsg()
      ]);
    } //End if error


    return response()->json([
      'error' => "",
      'coWorkerResData' => $userResult["searchResult"]
    ]);
  } // end findUserEdit


  public function delete(Request $request)
  {
    //check if the department or company id is a number
    if (!is_numeric($request->user_id)) {
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg(),
      ], 201);
    }

    try {
      //No errors delete user
      User::where('id', $request->user_id)->delete();
      return response()->json([
        'error' => '',
      ], 201);
    } catch (\Exception $e) {
      // dd($e);
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg(),
      ], 422);
    } // end try catch

  } // end delete


}//end main class
