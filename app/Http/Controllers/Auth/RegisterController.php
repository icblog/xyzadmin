<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends BaseController
{

  //METHODS USED FROM HELPER TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
  //returnGenericSystemErrMsg

  //METHODS USED FROM TOKEN TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
  //genarateToken



  public function store(Request $request)
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
        'departmentSelectedId' => 'required'
      ],
      ['departmentSelectedId.required' => 'Please select a department']
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
        $user->department_company = $request->departmentSelectedId;
        $user->uip = $request->ip();
        $user->created_updated_by = Auth::user()->id;
        $user->save();


        $emailTemplate = "mail.reg-email-template";

        $sendLinkOutCome = $this->sendRegEmail($request->first_name, $username, $request->email, $password, $subject, $emailTemplate);

        if ($sendLinkOutCome["error"]) {
          return response()->json([
            'errors' => $this->returnGenericSystemErrMsg(),
            'error_code' => '04',
          ], 422);
        } //End if out come error

        if ($sendLinkOutCome["outcome"]) {
          return response()->json([
            'errors' => ''
          ], 201);
        } //End if out come error

      } catch (\Exception $e) {
        // dd($e);
        return response()->json([
          'errors' => $this->returnGenericSystemErrMsg(),
          'error_code' => '05',
        ], 422);
      } // end try catch



    } //end if user is not null



  } // end method store

}//end class
