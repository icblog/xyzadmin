<?php

namespace App\Http\Controllers\Phone;
use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Phones;
use App\Models\DepartmentAndCompany;


class PhoneController extends BaseController{

   public function index(){

    $view_phone_res = Phones::fetchPhonesAndDepartments();
   

    if($view_phone_res['error']){
        return redirect()
          ->route('viewphone.index')
          ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
          ->withInput();
    }

    return Inertia::render('phone/PhoneHome',[
        'view_phone_res'=>$view_phone_res['result']
    ]);

  }//end index

  public function addPhoneIndex(){

    $departmnet_result = DepartmentAndCompany::fetchDepartmentsAndCompanies();

    if($departmnet_result['error']){
        return redirect()
          ->route('addphone.index')
          ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
          ->withInput();
    }
    
    return Inertia::render('phone/AddPhone',['department_res'=>$departmnet_result['departmentResult']]);

  }//end add phoneIndex

  public function editPhoneIndex(){

    $departmnet_result = DepartmentAndCompany::fetchDepartmentsAndCompanies();

    if($departmnet_result['error']){
        return redirect()
          ->route('editphone.index')
          ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
          ->withInput();
    }
    
    return Inertia::render('phone/EditPhone',['department_res'=>$departmnet_result['departmentResult']]);

  }//end add phoneIndex

  public function store(Request $request){
    
    $attr_names = array(
        'selected_department_id' => 'department',
        'phone_desc_valid' => 'name or description or phone',
       );


       $validator = Validator::make($request->all(), [
        'selected_department_id' => 'required|integer',
        'phone_desc_valid' => 'required|string',
       ],
     ['selected_department_id.required'=>'Please select a department',
     'phone_desc_valid.required'=>'Please check you have filled in the name or decription and phone correctly'
    ],
    );

    //set custom form input names
   $validator->setAttributeNames($attr_names);

   //check if phone number exist in department already

   $found_numbers = "";
   
   foreach ($request->phone_desc as $phone_desc) {
      $number_check = Phones::where('phone', trim($phone_desc['phone']))->where('depart_comp_id', $request->selected_department_id)->first();
      if(!is_null($number_check)){
        $found_numbers .= trim($phone_desc['phone']).",";
      }
   }

   $found_numbers_msg = "The following ".$found_numbers." already exist for ".$request->selected_department_name." department";

   if($found_numbers !=''){
     
    $validator->after(function ($validator) use($request,$found_numbers_msg){
   
        $validator->errors()->add(
          'phone_desc_valid', $found_numbers_msg
        );
     });
   }


   if ($validator->fails()) {
    return redirect()
            ->route('addphone.index')
            ->withErrors($validator)
            ->withInput();
     die();
  }//end if validation

          //Save the data in db
          try {

            foreach ($request->phone_desc as $phone_desc) {
             
               $phone = new Phones();
               $phone->phone = $phone_desc['phone'];
               $phone->description = $phone_desc['desc'];
               $phone->depart_comp_id = $request->selected_department_id;
               $phone->created_by = Auth::user()->id;
               $phone->save();
            }
    
              $request->session()->put('respondsMsg', "code200");
              return redirect()
               ->route('addphone.index');
              die();
        } catch (\Exception $e) {
           // dd($e);
            return redirect()
            ->route('addphone.index')
            ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
            ->withInput();
           }
          

}//end store

public function fetchDepartmentPhones(Request $request) {

  try {
    $department_phones_res = Phones::select('id','phone','description')->where('depart_comp_id',$request->department_id)->get();
 
    return response()->json([
      'error' => '',
      'department_phones_res'=>$department_phones_res,
     ], 201);
  
  } catch (\Exception $e) {
   // dd($e);
    return redirect()
    ->route('editphone.index')
    ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
    ->withInput();
   }
     

}// end fetchDepartmentPhones

public function delete(Request $request){

    try {

      Phones::where('id', $request->phone_id)->delete();
      
        return response()->json([
         'error' => ''
        ], 201);
       
    } catch (\Exception $e) {
      // dd($e);
       return response()->json([
         'error' => $this->returnGenericSystemErrMsg(),
      ], 422);
           
   }// end try catch
  
}// end delete


public function update(Request $request){


  if($request->desc_new_value == "" || $request->phone_new_value ==""){
    return response()->json([
      'error' =>  "Please fill in description or the phone number field."
     ]);
  }

   if($request->desc_new_value == $request->desc_old_value && $request->phone_new_value == $request->phone_old_value){
    return response()->json([
      'error' =>  "Please make a change before saving thank you."
     ]);
  }

  try {

    $array_data = array(
      'description'=> $request->desc_new_value,
      'phone'=> $request->phone_new_value,
      'updated_by'=> Auth::user()->id
    );

    Phones::where('id', $request->phone_id)->update($array_data);
    
      return response()->json([
       'error' => ''
      ], 201);
     
  } catch (\Exception $e) {
    // dd($e);
     return response()->json([
       'error' => $this->returnGenericSystemErrMsg(),
    ], 401);
         
 }// end try catch

}// end update

}//end main class