<?php

namespace App\Http\Controllers\DepartmentAndCompany;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\DepartmentAndCompany;
use App\Models\Phones;
use App\Models\User;



class DepartmentAndCompanyController extends BaseController{

  public function index(){

    return Inertia::render('departcomp/AddDepartmentOrCompany');

  }//end index

  public function viewAllDepartCompIndex(Request $request){

    $depart_coworker_count = DepartmentAndCompany::fetchDepartmentsWithCoWorkerCount();
    
    if($depart_coworker_count['error']){
      return redirect()
      ->route('viewalldepartcomp.index')
      ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
      ->withInput();
    }
  
    $result_per_page = $this->returnResultPerPageNumber();//Find this in base controller
    $option_selected = $request->has('option_selected')? $request->option_selected: "";
    $searched_word = $request->has('searched_word')? $request->searched_word:"";
    
    $view_all_res_data = DepartmentAndCompany::viewAllDepartmentCompany($option_selected,$searched_word,true,$result_per_page);
    
    if($view_all_res_data['error']){
      return redirect()
      ->route('viewalldepartcomp.index')
      ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
      ->withInput();
    }


     
      return Inertia::render('departcomp/ViewDepartmentOrCompany',[
        'view_depart_comp_prop_res'=> $view_all_res_data['view_all_departcomp_data'],
        'depart_coworker_count_result'=>$depart_coworker_count['depart_coworker_count_result'],
      ]);

 }//end viewAllDepartCompIndex

  

  public function store(Request $request){

    $validator = Validator::make($request->all(), [
      'name' => 'required|string|unique:department_and_companies',
      'email'=> 'nullable|string|email',
      'desc' => 'required|string',
      'phone'=> 'required|string',
      'is_company'=> 'required|int',
   ],
   ['name.required'=>'Please enter department or company name',
   'name.unique'=>'Department or company name already exist, please enter a different name thank you.',
   'desc.required'=>'Please ensure the phone description is filled in',
   'phone.required'=>'Number or extension is required',
   'is_company.required'=>'Please indicate if department or company']
  );

  $validator->after(function ($validator) use($request){
    if ($request->is_company != "" && $request->is_company === 1) {
       if (!is_numeric($request->is_quick_company)) {
          $validator->errors()->add(
          'is_quick_company', 'Please indicate if to make it a quick company'
        );
       }
    }
 });

  //Check for validation errors
  if ($validator->fails()) {
    return response()->json([
        'errors' => $validator->errors()->all(),
        'error_code'=> 'add_depart_comp_01',
    ]);
   die();
  }//end if validation


   // save data in database
   try {
      $loggedin_user_id = Auth::user()->id;
      $depart_comp = new DepartmentAndCompany();
      $depart_comp->name = $request->name;
      $depart_comp->is_depart_or_comp = $request->is_company;

      if(is_numeric($request->is_quick_company)){
        $depart_comp->is_quick = $request->is_quick_company;
      }
      $depart_comp->created_by = $loggedin_user_id;

      if($request->email !=''){
        $depart_comp->email = $request->email;
      }
      $depart_comp->save();
   
      //Save phone name or description and number

      $phone = new Phones();
      $phone->phone = $request->phone;
      $phone->description = $request->desc;
      $phone->depart_comp_id = $depart_comp->id; //last inserted id
      $phone->created_by = $loggedin_user_id;
      $phone->save();

      return response()->json([
        'errors' => ''
       ], 201);

  } catch (\Exception $e) {
    // dd($e);
     return response()->json([
       'errors' => $this->returnGenericSystemErrMsg(),
       'error_code'=> 'add_depart_comp_02'
    ], 422);
         
 }// end try catch

}//end store

public function update(Request $request){

  $validator = Validator::make($request->all(), [
    'name' => 'required|string',
    'is_company'=> 'required|int',
    'email'=> 'nullable|string|email',
 ],
 ['name.required'=>'Please enter department or company name',
 'is_company.required'=>'Please indicate if department or company']
);

$validator->after(function ($validator) use($request){
  if ($request->is_company != "" && $request->is_company === 1) {
     
    if (!is_numeric($request->is_quick_company)) {
        $validator->errors()->add(
        'is_quick_company', 'Please indicate if to make it a quick company'
      );
     }
   
  }

  //if name has change check db to unsure it's unique
  if($request->old_name != '' && $request->old_name != $request->name){
     $check_res = DepartmentAndCompany::select('id')->where('name','=', $request->name)->first();
     if(!is_null($check_res)){
      $validator->errors()->add(
        'name', 'Department or company name already exist, please enter a different name thank you.'
      );
     }
  }


 });

//Check for validation errors
if ($validator->fails()) {
  return response()->json([
      'errors' => $validator->errors()->all(),
      'error_code'=> 'edit_depart_comp_01',
  ]);
 die();
}//end if validation

//Update data
try {

  $array_data = array(
    'name'=> $request->name,
     'is_depart_or_comp'=> $request->is_company,
    'is_quick'=>$request->is_company === 0? 0 : $request->is_quick_company,
    'updated_by'=> Auth::user()->id
  );

  if($request->email != "" || $request->email != null){
    $array_data['email'] = $request->email;
  }

  DepartmentAndCompany::where('id', $request->depart_comp_id)->update($array_data);
  
    return response()->json([
     'errors' => '',
     'updated_by_fname' => Auth::user()->fname,
     'updated_by_lname' => Auth::user()->lname,
    ], 201);
   
} catch (\Exception $e) {
  // dd($e);
   return response()->json([
     'errors' => $this->returnGenericSystemErrMsg(),
     'error_code'=> 'edit_depart_comp_02',
  ], 401);
       
}// end try catch

}//end update method


public function delete(Request $request){
  //check if the department or company id is a number
  if(!is_numeric($request->depart_comp_id)){
    return response()->json([
      'error' => $this->returnGenericSystemErrMsg(),
     ], 201);
  }

  try {

    //Check if there are co-wokers inthe department being deleted if it is department.
    if($request->depart_or_comp == "department"){
        
      $result = User::select("id")->where("department",$request->depart_comp_id)->first();
       
        if(!is_null($result)){
          return response()->json([
            'error' => 'Sorry, there are some co-workers in '.$request->depart_comp_name.' department, please move them into another department before deleting thank you.',
           ], 201);
         }
    
      }
   
     //No co-wrokers delete department and phones contected.
     DepartmentAndCompany::where('id', $request->depart_comp_id)->delete();
     Phones::where('depart_comp_id', $request->depart_comp_id)->delete();
    
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
  
public function getDepartCoWorkers(Request $request){
  if(!is_numeric($request->depart_id)){
    return response()->json([
      'error' => $this->returnGenericSystemErrMsg(),
     ], 201);
  }

  try {
      $co_workers_res = DepartmentAndCompany::fetchCoWorkersByDepartment($request->depart_id);
     
      if($co_workers_res['error']){
        return response()->json([
          'error' => $this->returnGenericSystemErrMsg(),
         ], 201);
      }

      return response()->json([
        'error' => "",
        'depart_coworkers_res' => $co_workers_res['depart_coworker_results'],
       ], 201);

  } catch (\Exception $e) {
    // dd($e);
     return response()->json([
       'error' => $this->returnGenericSystemErrMsg(),
   ], 201);
         
 }// end try catch

}// end getDepartCoWorkers


}//end main class
