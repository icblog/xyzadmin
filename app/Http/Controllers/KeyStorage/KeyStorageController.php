<?php

namespace App\Http\Controllers\KeyStorage;

use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\KeyStorage;
use App\Models\Key;
use App\Models\KeyAuth;


class KeyStorageController extends BaseController
{

  public function index(Request $request)
  {

    //Fetch all key storage
    $result_per_page = $this->returnResultPerPageNumber(); //Find this in base controller
    $paginate = true;

    $selected_sort_option = $request->has('selected_sort_option') ? $request->selected_sort_option : "";
    $storage = $request->has('storage') ? $request->storage : "";

    $key_storage_res = KeyStorage::allStorage(
      $selected_sort_option,
      $storage,
      $paginate,
      $result_per_page
    );


    if ($key_storage_res['error']) {

      return redirect()
        ->route('keystorage.index')
        ->withErrors(["fail" => $this->returnGenericSystemErrMsg()])
        ->withInput();
    }

    if (!$request->first_page_load) {
      $request->session()->put('respondsMsg', "searching_or_sorting");
    } else {
      $request->session()->put('respondsMsg', "");
    }

    return Inertia::render('key/KeyStorage', [
      'key_storage_res' => $key_storage_res['key_storage_data'],

    ]);
  } //end  index

  public function save(Request $request)
  {

    if ($request->storage == "") {
      return response()->json([
        'error' => "*Please enter storage name before saving thanks",
      ]);
      die();
    }

    //Save data in DB

    try {

      $storage = new KeyStorage();
      $storage->created_by = Auth::user()->id;
      $storage->name = $this->cleanData($request->storage); //Helper trait
      $storage->save();
      return response()->json([
        "error" => '',
      ]);
    } catch (\Exception $e) {

      return response()->json([
        'error' => $this->returnGenericSystemErrMsg(),
      ], 422);
    }
  } //End save

  public function update(Request $request)
  {

    //Validate request variables
    if (!is_numeric($request->data_id)) {
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg(),
      ], 201);
    }


    if ($request->data_new_value == "") {
      return response()->json([
        'error' =>  "*Please enter a storage name"
      ]);
    }

    if ($request->data_new_value == $request->data_old_value) {
      return response()->json([
        'error' =>  "*Please make a change before saving thank you."
      ]);
    }

    try {

      $array_data = array(
        'name' => $this->cleanData($request->data_new_value), // help/trai
        'updated_by' => Auth::user()->id
      );
      //Update key storage
      KeyStorage::where('id', $request->data_id)->update($array_data);

      //Update keys name column because storage has changed
      $keys_res = Key::select("id", "name")->where('storage_id', $request->data_id)->get();
      if (!empty($keys_res)) {
        foreach ($keys_res as $key) {
          Key::where('id', $key->id)->update(['name' => Str::replaceFirst($request->data_old_value, $request->data_new_value, $key->name)]);
        }
      }

      return response()->json([
        'error' => '',
        'updated_by_f' => Auth::user()->fname,
        'updated_by_l' => Auth::user()->lname,
        'updated_on' => $this->returnTimeStamp(),
      ], 201);
    } catch (\Exception $e) {
      // dd($e);
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg(),
      ], 401);
    } // end try catch

  } // end update

  public function delete(Request $request)
  {

    //Validate request variables
    if (!is_numeric($request->data_id)) {
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg(),
      ], 201);
    }

    try {
      //Delete storage by storage id
      KeyStorage::where('id', $request->data_id)->delete();
      // Get key id by the storage id
      $keys_res = Key::select("id")->where('storage_id', $request->data_id)->get();

      if (!empty($keys_res)) {
        //Delete all keys by storage id
        Key::where('storage_id', $request->data_id)->delete();
        foreach ($keys_res as $key) {
          //Delete keyAuth by the key id that was fetch
          KeyAuth::where('key_id', $key->id)->delete();
        }
      }

      return response()->json([
        'error' => '',
      ], 201);
    } catch (\Exception $e) {
      // dd($e);
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg(),
      ], 401);
    } // end try catch

  } // end delete

}//end main class