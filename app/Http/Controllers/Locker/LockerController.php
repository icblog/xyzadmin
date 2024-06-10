<?php

namespace App\Http\Controllers\Locker;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Locker;
use App\Models\User;




class LockerController extends BaseController{

  public function addLockerIndex(){

    return Inertia::render('locker/AddLocker');

  }//end addLockerIndex

  public function index(Request $request){

    $result_per_page = $this->returnResultPerPageNumber();//Find this in base controller
    $option_selected = $request->has('option_selected')? $request->option_selected: "";
    $searched_word = $request->has('searched_word')? $request->searched_word:"";
    
    $view_all_res_data = Locker::fetchLockers($option_selected,$searched_word,true,$result_per_page);
    
    if($view_all_res_data['error']){
      return redirect()
      ->route('viewlocker.index')
      ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
      ->withInput();
    }

      return Inertia::render('locker/ViewLockers',[
        'view_locker_prop_obj'=> $view_all_res_data['lockers_data'],
        
      ]);
  }//end index

  

  public function store(Request $request){

    $validator = Validator::make($request->all(), [
      'name' => 'required|string|unique:lockers',
      'comment' => 'nullable|string',
      
   ],
   ['name.required'=>'Please enter locker name or number',
   'name.unique'=>'Locker name or number already exist, please enter a different one thank you.',
   ]
  );
   
  //Check for validation errors
  if ($validator->fails()) {
    return response()->json([
        'errors' => $validator->errors()->all(),
        'error_code'=> 'add_locker_01',
    ]);
   die();
  }//end if validation


   // save data in database
   try {
      $loggedin_user_id = Auth::user()->id;
      $locker = new Locker();
      $locker->name = $request->name;
       if($request->comment != ''){
        $locker->comment = $request->comment;
       }
      $locker->created_by = $loggedin_user_id;
      $locker->save();
   
      return response()->json([
        'errors' => ''
       ], 201);

  } catch (\Exception $e) {
    // dd($e);
     return response()->json([
       'errors' => $this->returnGenericSystemErrMsg(),
       'error_code'=> 'add_locker_02'
    ], 422);
         
 }// end try catch

 }//end store

public function update(Request $request){

  if($request->action == 'edit'){

    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'comment' => 'nullable|string',
      
   ],
   ['name.required'=>'Please enter locker name or number',
   'name.unique'=>'Locker name or number already exist, please enter a different one thank you.',
   ]
  );

  $validator->after(function ($validator) use($request){
   //check to ensure locker name is unique, if it has been changed
    if($request->old_locker_name !='' && $request->old_locker_name != $request->name){
      $locker_name_check = Locker::select('id')->where('name',$request->name)->first();
      if(!is_null($locker_name_check)){
        $validator->errors()->add(
          'name', 'Locker name already exist, please enter a different name thank you.'
        );
      }
    }
     
  });
   
   
  //Check for validation errors
  if ($validator->fails()) {
    return response()->json([
        'errors' => $validator->errors()->all(),
        'error_code'=> 'edit_locker_01',
    ]);
   die();
  }//end if validation

    try {
      
      Locker::where('id', $request->locker_id)->update([
        'name'=> $request->name,
        'comment'=> $request->comment,
        'locker_status'=> $request->status,
        'updated_by'=> Auth::user()->id,
      ]);

      //Update user locker id if previous locker status is 1

      if($request->old_status === 1 && $request->status === 0 || $request->status === 2){
        User::where('locker', $request->locker_id)->update([
          'locker'=> 0,
          'what_was_change'=>'Removed a locker',
          'updated_by'=> Auth::user()->id,
        ]);
      }
     
      return response()->json([
       'errors' => '',
      //  'updated_by_fname' => Auth::user()->fname,
      //  'updated_by_lname' => Auth::user()->lname,
      ], 201);
     
  } catch (\Exception $e) {
    // dd($e);
     return response()->json([
       'errors' => $this->returnGenericSystemErrMsg(),
       'error_code'=> 'update_locker_05',
    ], 401);
         
  }// end try catch

}else if($request->action =='assign'){
  try {
    User::where('id', $request->coworker_id)->update([
      'locker'=> $request->locker_id,
      'what_was_change'=>'Assigned a locker',
      'updated_by'=> Auth::user()->id,
    ]);

    Locker::where('id', $request->locker_id)->update([
      'locker_status'=> 1,
      'updated_by'=> Auth::user()->id,
    ]);

    //Update coworker old locker if they had one
    if($request->previous_coworker_locker > 0){
      Locker::where('id', $request->previous_coworker_locker)->update([
        'locker_status'=> 0,
        'updated_by'=> Auth::user()->id,
      ]);
    }
  
    return response()->json([
     'error' => '',
   
    ], 201);
   
} catch (\Exception $e) {
  // dd($e);
   return response()->json([
     'error' => $this->returnGenericSystemErrMsg(),
     'error_code'=> 'update_locker_05',
  ], 401);
       
}// end try catch

}else{
  return response()->json([
    'error' => $this->returnGenericSystemErrMsg(),
    'error_code'=> 'update_locker_06',
 ], 401);
}// end action

}//end update method


public function delete(Request $request){
  //check if locker id is a number
  if(!is_numeric($request->locker_id)){
    return response()->json([
      'error' => $this->returnGenericSystemErrMsg(),
     ], 201);
  }

  try {
    
     Locker::where('id', $request->locker_id)->delete();

     return response()->json([
      'error' => '',
     ], 201);
   
  } catch (\Exception $e) {
    // dd($e);
     return response()->json([
       'error' => $this->returnGenericSystemErrMsg(),
    ], 422);
         
 }// end try catch

}// end delete
  
}//end main class