<?php

namespace App\Http\Controllers\VisitingReason;
use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reason;



class VisitingReasonsController extends BaseController{
 
  public function index(Request $request){
  
        //Fetch all visiting reason
        $result_per_page = $this->returnResultPerPageNumber();//Find this in base controller
        $paginate = true;
      
        $selected_sort_option = $request->has('selected_sort_option')? $request->selected_sort_option:"";
        $reason = $request->has('reason')? $request->reason:"";
      
       $visiting_reason_res = Reason::visitingReasons(
         $selected_sort_option,
         $reason,
         $paginate,
         $result_per_page
        );
      
       if($visiting_reason_res['error']){
        
        return redirect()
          ->route('visitingreasons.index')
          ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
          ->withInput();
          
        }
      
        if(!$request->first_page_load){
            $request->session()->put('respondsMsg', "searching_or_sorting");
        }else{
            $request->session()->put('respondsMsg', "");
        }
      
        return Inertia::render('visitors/VisitingReasons', [
         'reason_res'=> $visiting_reason_res['reasons_data'],
          
         ]);

    }// end index

    public function save(Request $request){

        if($request->reason == ""){
            return response()->json([
                'error' => "*Please enter visiting reason",
            ]);
            die();
        }

        if(!is_numeric($request->quick_reason)){
            return response()->json([
                'error'=>"*Please indicate either to make it a quick reason",
            ]);
            die();
        }

      
      //Save data in DB
      
       try {
      
           $reason = new Reason();
             $reason->created_by = Auth::user()->id;
             $reason->name = $request->reason;
             $reason->quick_reason = $request->quick_reason === 0? "no": "yes";
             $reason->save();
             return response()->json([
                   "error" => "",
                ]);
        } catch (\Exception $e) {
      
              return response()->json([
                'error' => $this->returnGenericSystemErrMsg(),
              ],422);
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
      
         if($request->data_new_value == $request->data_old_value && $request->is_quick_reason == $request->is_quick_reason_old){
          return response()->json([
            'error' =>  "Please make a change before saving thank you."
           ]);
        }
      
        try {
      
          $array_data = array(
            'name'=> $request->data_new_value,
            'quick_reason'=> $request->is_quick_reason,
            'updated_by'=> Auth::user()->id
          );
      
          Reason::where('id', $request->data_id)->update($array_data);
          
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
    
        Reason::where('id', $request->data_id)->delete();
          
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


