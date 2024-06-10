<?php

namespace App\Http\Controllers\KeyLog;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Key;
use App\Models\User;
use App\Models\KeyLog;





class KeyLogController extends BaseController
{

    public function index(Request $request)
    {

        $result_per_page = $this->returnResultPerPageNumber(); //Find this in base controller
        $paginate = true;
        $selected_sort_option = $request->has('selected_sort_option') ? $request->selected_sort_option : "";
        $key_name = $request->has('key_name') ? $request->key_name : "";
        $start_date = $request->has('start_date') ? $request->start_date : "";
        $end_date = $request->has('end_date') ? $request->end_date : "";
        $has_date_changed = $request->has('has_date_changed') ? $request->has_date_changed : "no";
        $view_key_log_result = KeyLog::showAllKeyLogData($selected_sort_option, $key_name, $start_date, $end_date, $has_date_changed, $paginate, $result_per_page);

        return Inertia::render(
            'key/KeyLog',
            [
                'view_key_log_res' => $view_key_log_result['key_log_data'],
            ]
        );
    } //index


    public function findCoworker(Request $request)
    {
        if (!is_string($request->searchedword)) {
            return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
            ]);
        } //End if error

        $userResult =  User::searchUser($request->searchedword, 'with_department');


        if ($userResult["error"]) {

            return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
            ]);
        } //End if error


        return response()->json([
            'error' => "",
            'coWorkerResData' => $userResult["searchResult"]
        ]);
    } // end findCoworker

    public function findKey(Request $request)
    {
        if (!is_string($request->searchedword)) {
            return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
            ]);
        } //End if error

        $data_outcome  =  Key::findAkey(0, $request->searchedword);

        if ($data_outcome["error"]) {
            return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
            ]);
        }
        return response()->json([
            'error' => "",
            'coWorkerResData' => $data_outcome["key_data"]
        ]);
    } // end findKey


    public function logAkey(Request $request)
    {

          $logger_name = Auth::user()->fname . " " . Auth::user()->lname;
        
        if ($request->action == "keyout") {
            
        try {
             //Store
             $key_log = new KeyLog();
             $key_log->key_name = $request->key_name;
             $key_log->coworker_name_out = $request->coworker_name; 
             $key_log->coworker_department_out = $request->coworker_department; 
             $key_log->is_coworker_authorized = $request->is_coworker_authorized; 
             $key_log->risk_coworker_name_out  = $logger_name;
             if($request->comment != ''){
                 $key_log->comment = $request->comment;  
             }
             $key_log->save();

             key::where("id", $request->key_id)->update([
                'status'=> 1
             ]);
 
 
             return response()->json([
                 'error' => ''
                ], 201);

        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
              'error' => $this->returnGenericSystemErrMsg(),
            ], 401);
          } // end try catch
           

        } else if ($request->action == "keyin") {
            
            $date_to_update  = array(
                "coworker_name_in"=>$request->coworker_name,
                "coworker_department_in"=>$request->coworker_department,
                "comment"=> $request->comment,
                "risk_coworker_name_in" => $logger_name,
                "in_at" => $this->returnTimeStamp()
            );
            try{
                KeyLog::where('id', $request->key_log_id)->update($date_to_update);
                key::where("name", $request->key_name)->update([
                    'status'=> 0
                 ]);
                
                return response()->json([
                    'error' => ''
                ], 201);

            } catch (\Exception $e) {
                // dd($e);
                return response()->json([
                  'error' => $this->returnGenericSystemErrMsg(),
                ], 401);
              } // end try catch
        
        } else {
            return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
            ]);
        }// end if


    } // end logAkey


}//end main class