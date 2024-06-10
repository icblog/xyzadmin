<?php

namespace App\Http\Controllers\Key;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\KeyStorage;
use App\Models\Key;
use App\Models\KeyAuth;
use App\Models\DepartmentAndCompany;
use App\Models\User;




class KeyController extends BaseController
{

  public function index(Request $request)
  {

    $key_storage_res = KeyStorage::select('id', 'name')->get();

    $result_per_page = $this->returnResultPerPageNumber(); //Find this in base controller
    $option_selected = $request->has('option_selected') ? $request->option_selected : "";
    $searched_word = $request->has('searched_word') ? $request->searched_word : "";
    $storage_id = $request->has('storage_id') ? $request->storage_id : 0;

    $view_all_res_data = Key::fetchKeys($option_selected, $searched_word, true, $result_per_page, $storage_id);

    if ($view_all_res_data['error']) {
      return redirect()
        ->route('viewkeys.index')
        ->withErrors(["fail" => $this->returnGenericSystemErrMsg()])
        ->withInput();
    }

    return Inertia::render('key/ViewKeys', [
      'view_keys_prop_obj' => $view_all_res_data['keys_data'],
      'key_storage_res' => $key_storage_res,
      'search_word' => $searched_word,
    ]);
  } // end index

  public function addKeyIndex()
  {
    $key_storage_res = KeyStorage::select('id', 'name')->get();
    $department_res = DepartmentAndCompany::select('id', 'name')
      ->orderBy('department_and_companies.name', 'ASC')
      ->get();

    return Inertia::render('key/AddKey', [
      'key_storage_res' => $key_storage_res,
      'department_res' => $department_res,
    ]);
  } //end addkeyIndex

  public function store(Request $request)
  {
    // Key::query()->truncate();
    // return;
    $validator = Validator::make(
      $request->all(),
      [
        'name' => 'required|string|unique:keys',
        'comment' => 'nullable|string',
        'description' => 'required|string',
        'key_storage_id' => 'int',
        'selected_department' => 'array',
        'selected_coworker' => 'array',

      ],
      [
        'name.required' => 'Please enter Key name or number',
        'name.unique' => 'Key name or number already exist, please enter a different one thank you.',
      ]
    );

    $validator->after(function ($validator) use ($request) {
      if ($request->key_storage_id === 0) {
        $validator->errors()->add(
          'key_storage_id',
          'Please select storage for the key'
        );
      }

      if (count($request->selected_department) === 0 && count($request->selected_coworker) === 0) {
        $validator->errors()->add(
          'selected_department',
          'Please completed this section by selecting a department, co-workers or both'
        );
      }
    });

    //Check for validation errors
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors()->all(),
        'error_code' => 'add_key_01',
      ]);
      die();
    } //end if validation

    //  dd($request->selected_coworker);

    // save data in database
    try {
      $loggedin_user_id = Auth::user()->id;
      $new_key = new Key();
      $new_key->name = $request->key_storage_name . "-" . $request->name;
      $new_key->description = $request->description;
      $new_key->storage_id = $request->key_storage_id;
      if ($request->comment != '') {
        $new_key->comment = $request->comment;
      }
      $new_key->created_by = $loggedin_user_id;
      $new_key->save();



      if (count($request->selected_department) > 0) {
        foreach ($request->selected_department as $department) {
          $key_auth = new KeyAuth;
          $key_auth->key_id = $new_key->id;
          $key_auth->auth_type = 1; // 0 means co-worker id, 1 means department id
          $key_auth->auth_type_id = $department['id'];
          $key_auth->created_by = $loggedin_user_id;
          $key_auth->save();
        }
      }

      if (count($request->selected_coworker) > 0) {
        foreach ($request->selected_coworker as $coworker) {
          $key_auth = new KeyAuth;
          $key_auth->key_id = $new_key->id;
          $key_auth->auth_type_id = $coworker['id'];
          $key_auth->created_by = $loggedin_user_id;
          $key_auth->save();
        }
      }

      return response()->json([
        'errors' => ''
      ], 201);
    } catch (\Exception $e) {
      //dd($e);
      return response()->json([
        'errors' => $this->returnGenericSystemErrMsg(),
        'error_code' => 'add_key_02'
      ], 422);
    } // end try catch

  } //end store



  public function updateKeyIndex(Request $request, int $key_id)
  {
    $key_res = array();
    $key_storage_res = array();
    $department_res = array();
    $coworker_key_auth = array();
    $depart_key_auth = array();

    $key_res = Key::fetchAKeyForUpdate($key_id);

    if (!is_null($key_res['key_data'])) {

      $key_storage_res = KeyStorage::select('id', 'name')->get();

      $department_res = DepartmentAndCompany::select('id', 'name')
        ->orderBy('department_and_companies.name', 'ASC')
        ->get();

      $get_key_auth_res = $this->getKeyAuth($request, $key_id);
      $coworker_key_auth =  $get_key_auth_res['coworker_key_auth'];
      $depart_key_auth =  $get_key_auth_res['depart_key_auth'];
    }


    return Inertia::render('key/EditKey', [
      'key_storage_res' => $key_storage_res,
      'department_res' => $department_res,
      'key_res' =>  $key_res['key_data'],
      'coworker_key_auth_res' => $coworker_key_auth,
      'depart_key_auth_res' => $depart_key_auth,
    ]);
  } // end updateKeyIndex



  public function update(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'name' => 'required|string',
        'description' => 'required|string',
        'comment' => 'nullable|string',
        'key_storage_id' => 'int',
        'key_status' => 'int',
        'selected_department' => 'array',
        'selected_coworker' => 'array',

      ],
      [
        'name.required' => 'Please enter Key name or number',

      ]
    );

    $validator->after(function ($validator) use ($request) {
      if ($request->name != $request->old_name) {
        $key_name_check = Key::select('id')->where("name", $request->name)->first();
        if (!is_null($key_name_check)) {
          $validator->errors()->add(
            'name',
            'Key name or number already exist, please enter a different one thank you.'
          );
        }
      }

      if (count($request->selected_department) === 0 && count($request->selected_coworker) === 0) {
        $validator->errors()->add(
          'selected_department',
          'Please completed this section by selecting a department, co-workers or both'
        );
      }
    });

    //Check for validation errors
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors()->all(),
        'error_code' => 'edit_key_01',
      ]);
      die();
    } //end if validation

    try {
      $loggedin_user_id = Auth::user()->id;
      $key_name_to_save = $request->name;

      if ($request->name != $request->old_name) {
        //Check if key name has change
        if (!Str::contains($key_name_to_save, $request->key_storage_name . "-")) {
          $key_name_to_save =  $request->key_storage_name . "-" . $request->name;
        }
      } else if ($request->key_storage_id != $request->old_key_storage_id) {
        //Check if storage id has change
        $key_name_to_save = Str::replaceFirst($request->old_key_storage_name, $request->key_storage_name, $request->name);
      }

      $data_to_update = array(
        'name' => $key_name_to_save,
        'description' => $request->description,
        'status' => $request->key_status,
        'storage_id' => $request->key_storage_id,
        'updated_by' => $loggedin_user_id,
      );

      if ($request->comment != '') {
        $data_to_update['comment'] = $request->comment;
      } else {
        $data_to_update['comment'] = null;
      }

      Key::where('id', $request->key_id)->update($data_to_update);

      //Delete all key auth related to department
      KeyAuth::where("key_id", $request->key_id)->where('auth_type', 1)->delete();

      if (count($request->selected_department) > 0) {

        foreach ($request->selected_department as $department) {

          $key_auth = new KeyAuth;
          $key_auth->key_id = $request->key_id;
          $key_auth->auth_type = 1; // 0 means co-worker id, 1 means department id
          $key_auth->auth_type_id = $department['id'];
          $key_auth->created_by = $loggedin_user_id;
          $key_auth->save();
        }
      }
      //Delete all key auth related to co-workers
      KeyAuth::where("key_id", $request->key_id)->where('auth_type', 0)->delete();
      if (count($request->selected_coworker) > 0) {

        foreach ($request->selected_coworker as $coworker) {
          $key_auth = new KeyAuth;
          $key_auth->key_id = $request->key_id;
          $key_auth->auth_type_id = $coworker['id'];
          $key_auth->created_by = $loggedin_user_id;
          $key_auth->save();
        }
      }

      return response()->json([
        'errors' => '',
      ], 201);
    } catch (\Exception $e) {
      //dd($e);
      return response()->json([
        'errors' => $this->returnGenericSystemErrMsg(),
        'error_code' => 'update_key_02',
      ], 401);
    } // end try catch

  } //end update method

  public function getKeyAuth(Request $request, $key_id = 0)
  {


    $key_auth_res = array(
      'coworker_key_auth' => [],
      'depart_key_auth' => [],
    );

    if ($key_id == 0) {
      $key_id = $request->key_id;
    }

    $key_auths = KeyAuth::select('auth_type', 'auth_type_id')->where('key_id', $key_id)->get();

    if (!empty($key_auths)) {

      foreach ($key_auths as $key_auth) {

        if ($key_auth->auth_type == 0) {

          $coworker = User::select('id', 'fname', 'lname')->where('id', $key_auth->auth_type_id)->first();

          if (!is_null($coworker)) {
            $temp_arr = ['id' => $coworker->id, 'name' => $coworker->fname . ' ' . $coworker->lname];
            array_push($key_auth_res['coworker_key_auth'], $temp_arr);
          }
        } else if ($key_auth->auth_type == 1) {
          $depart_auth_res = DepartmentAndCompany::select('id', 'name')->where('id', $key_auth->auth_type_id)->first();
          if (!is_null($depart_auth_res)) {
            array_push($key_auth_res['depart_key_auth'], $depart_auth_res);
          }
        }
      }
    }
    if ($request->isMethod('post')) {
      return response()->json([
        'error' => '',
        'auth_data' => $key_auth_res
      ], 201);
    } else {
      return $key_auth_res;
    }
  } // end  getKeyAuth

  public function delete(Request $request)
  {
    //check if locker id is a number
    if (!is_numeric($request->key_id)) {
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg(),
      ], 201);
    }

    try {

      Key::where('id', $request->key_id)->delete();
      KeyAuth::where('key_id', $request->key_id)->delete();

      return response()->json([
        'error' => '',
      ], 201);
    } catch (\Exception $e) {
      //dd($e);
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg(),
      ], 422);
    } // end try catch

  } // end delete



}//end main class