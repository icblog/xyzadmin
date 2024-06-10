<?php

namespace App\Http\Controllers\CommonAbsenceReason;
use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\CommonAbsenceReason;

class CommonAbsenceReasonController extends BaseController{

  public function index(Request $request){
  
    //Fetch all absence reason
    $result_per_page = $this->returnResultPerPageNumber();//Find this in base controller
    $paginate = true;
 
    $selected_sort_option = $request->has('selected_sort_option')? $request->selected_sort_option:"";
    $reason = $request->has('reason')? $request->reason:"";

   $absence_reason_res = CommonAbsenceReason::absenceReasons(
     $selected_sort_option,
     $reason,
     $paginate,
     $result_per_page
    );

   if($absence_reason_res['error']){
    
    return redirect()
      ->route('absencereason.index')
      ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
      ->withInput();
      
    }

    if(!$request->first_page_load){
        $request->session()->put('respondsMsg', "searching_or_sorting");
    }else{
        $request->session()->put('respondsMsg', "");
    }

    return Inertia::render('absence/CommonAbsenceReasons', [
     'reason_res'=> $absence_reason_res['absence_reason_data'],
      
     ]);
}//end  index

public function save(Request $request){

  if($request->reason == ""){
    return response()->json([
        'error' => "*Please enter absence reason before saving thanks",
    ]);
    die();
}
  
  //Save data in DB
  
   try {
  
       $reason = new CommonAbsenceReason();
         $reason->created_by = Auth::user()->id;
         $reason->name = $this->cleanData($request->reason);
         $reason->save();
         return response()->json([
               "error" => '',
            ]);
    } catch (\Exception $e) {
  
          return response()->json([
            'error' => $this->returnGenericSystemErrMsg(),
          ], 422);
   }

}//End save

public function update(Request $request){
   
    //Validate request variables
    if(!is_numeric($request->data_id)){
        return response()->json([
            'error' => $this->returnGenericSystemErrMsg(),
           ], 201);
    }
      

    if($request->data_new_value == ""){
      return response()->json([
        'error' =>  "Please enter a reason"
       ]);
    }
  
     if($request->data_new_value == $request->data_old_value){
      return response()->json([
        'error' =>  "Please make a change before saving thank you."
       ]);
    }
  
    try {
  
      $array_data = array(
        'name'=> $this->cleanData($request->data_new_value),// help/trait
        'updated_by'=> Auth::user()->id
      );
  
      CommonAbsenceReason::where('id', $request->data_id)->update($array_data);
      
        return response()->json([
         'error' => '',
         'updated_by_f'=> Auth::user()->fname,
         'updated_by_l'=> Auth::user()->lname,
         'updated_on'=> $this->returnTimeStamp(),
        ], 201);
       
    } catch (\Exception $e) {
      // dd($e);
       return response()->json([
         'error' => $this->returnGenericSystemErrMsg(),
      ], 401);
           
   }// end try catch
  
  }// end update

  public function delete(Request $request){
   
    //Validate request variables
    if(!is_numeric($request->data_id)){
        return response()->json([
            'error' => $this->returnGenericSystemErrMsg(),
           ], 201);
    }
      
    try {

     CommonAbsenceReason::where('id', $request->data_id)->delete();
      
        return response()->json([
         'error' => '',
        ], 201);
       
    } catch (\Exception $e) {
      // dd($e);
       return response()->json([
         'error' => $this->returnGenericSystemErrMsg(),
      ], 401);
           
   }// end try catch
  
  }// end delete




}//end main class