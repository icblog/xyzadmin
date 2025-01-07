<?php

namespace App\Http\Controllers\AbsenceLog;

use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\CommonAbsenceReason;
use App\Models\Absence;
use App\Models\DepartmentAndCompany;
use App\Models\Phones;
use App\Models\User;



class AbsenceController extends BaseController
{


  public function index(Request $request)
  {

    //Fetch department with absence count

    $department_result = DepartmentAndCompany::fetchDepartmentsWithAbsentCount();

    if ($department_result['error']) {

      return redirect()
        ->route('viewabsence.index')
        ->withErrors(["fail" => $this->returnGenericSystemErrMsg()])
        ->withInput();
    } else {

      //Fetch all absence
      $result_per_page = $this->returnResultPerPageNumber(); //Find this in base controller
      $paginate = true;

      $selected_sort_option = $request->has('selected_sort_option') ? $request->selected_sort_option : "";
      $co_worker_name = $request->has('co_worker_name') ? $request->co_worker_name : "";
      $start_date = $request->has('start_date') ? $request->start_date : "";
      $end_date = $request->has('end_date') ? $request->end_date : "";
      $is_date_changed = $request->has('is_date_changed') ? $request->is_date_changed : "no";
      $selected_department_id = $request->has('selected_department_id') ? $request->selected_department_id : "";
      $work_related = $request->has('work_related') ? $request->work_related : "";

      $view_absence_res = Absence::viewAllAbsence(
        $selected_sort_option,
        $co_worker_name,
        $start_date,
        $end_date,
        $is_date_changed,
        $selected_department_id,
        $work_related,
        $paginate,
        $result_per_page
      );



      if ($view_absence_res['error']) {
        return redirect()
          ->route('viewabsence.index')
          ->withErrors(["fail" => $this->returnGenericSystemErrMsg()])
          ->withInput();
      }

      return Inertia::render('absence/AbsenceHome', [
        'view_absence_res' => $view_absence_res['view_all_absence_data'],
        'department_result' => $department_result['department_result'],
      ]);
    } // end department errors
  } //end  index

  public function absenceFindUser(Request $request){

    if (!is_string($request->searchedword)) {
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg()
      ]);
    } //End if error

    $userResult =  User::findCoworkersOnly($request->searchedword);
     //dd($userResult);

    if ($userResult["error"]) {

      return response()->json([
        'error' => $this->returnGenericSystemErrMsg()
      ]);
    } //End if error


    return response()->json([
      'error' => "",
      'coWorkerResData' => $userResult["co-worker_data"]
    ]);
  }

  public function absenceAdd()
  {
    $common_absence_reason_data = array(
      'absence_common_reason_res' => array(),
    );
    $common_absence_reason_res = CommonAbsenceReason::fetchCommonAbsenceReason();
    $common_absence_reason_data['absence_common_reason_res'] = $common_absence_reason_res['caReasonResult'];
    return Inertia::render('absence/AddAbsence', $common_absence_reason_data);
  }


  public function getCoworkersAndPhones(Request $request)
  {

    try {

      $co_workers_res = User::fetchCoworkerFirstAndLastName();
      $co_workers = explode(",", $co_workers_res['result'][0]->co_worker_fullname);
      $depart_phones_res = Phones::fetchPhonesAndDepartments();
      $depart_phones =  $depart_phones_res['result'];

      $co_worker_department = DepartmentAndCompany::select('name')->where('id', $request->department_id)->first();
      //dd($users);

      return response()->json([
        'error' => '',
        'depart_name' => $co_worker_department,
        'depart_phones_res' => $depart_phones,
        'co_workers' => $co_workers,
      ], 201);
    } catch (\Exception $e) {
      //dd($e);
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg(),
        'error_code' => '',
      ], 422);
    } // end try catch



  }

  // public function getCoworkerDepartResponsiblePhone(Request $request){

  //   $out_come_array = Absence::fetchCoworkerDepartResponsiblePhone($request->department_id);
  //   if(!$out_come_array['error']){
  //    $out_come_array['result'][0]->depart_phones =   explode(",",$out_come_array['result'][0]->depart_phones);
  //    $out_come_array['result'][0]->responsible_names = explode(",",$out_come_array['result'][0]->responsible_names);
  //       //To remove uneeded column
  //     ///unset($out_come_array['result'][0]->phone);

  //     return response()->json([
  //       'error' => '',
  //       'depart_responsible_phone_result'=> $out_come_array['result']
  //    ]);
  //   }

  // }


  public function store(Request $request)
  {

    //Check if myhouse the hidden recaptcha input is filled in,
    //if that is the case redirect to home page.

    if ($request->myhouse != '') {
      return redirect()->route('home.index');
      die();
    }

    $attr_names = array(
      'reason_option_selected_value' => 'reason',
      'work_related' => 'work related',
      'date_absence_for' => 'date absent for',
      'shift_start_time' => 'shift start time',
      'shift_end_time' => 'shift end time',
    );

    $validator = Validator::make($request->all(), [
      'reason_option_selected_value' => 'required|string',
      'work_related' => 'required|string',
      'date_absence_for' => 'required|string',
      'shift_start_time' => 'required|string',
      'shift_end_time' => 'required|string'
    ]);

    //set custom form input names
    $validator->setAttributeNames($attr_names);

    //Check for validation errors
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors()->all(),
        'error_code' => '06',
      ]);
      die();
    } //end if validation

    //Validation pass, store datails in database
    try {
      $responsible_informed = false;
      $comment = "None";
      if ($request->comment != '') {
        $comment = $request->comment;
      }

      $loggedin_user = Str::limit(Auth::user()->fname, 1, '.' . Auth::user()->lname);
      $absence = new Absence();
      $absence->ref_number = $request->ref_number;
      $absence->co_worker_name = $request->co_worker_name;
      $absence->depart_comp_id = $request->department_id;
      $absence->reason = $request->reason_option_selected_value;
      $absence->comment = $comment;
      $absence->work_related = $request->work_related;
      $absence->date_for = $request->date_absence_for;
      $absence->shift_start_time = $request->shift_start_time;
      $absence->shift_end_time = $request->shift_end_time;


      if ($request->responsible_told != 'Select....') {
        $responsible_informed =  true;
        $absence->responsible_told = $request->responsible_told;
        $absence->responsible_told_by =  $loggedin_user;
      }
      $absence->logged_by =  $loggedin_user;
      //save data to db
      $absence->save();

      $subject = "Your absence call";
      $emailTemplate = "mail.absence-coworker-responsible";
      //Send email to co-worker with ref number

      $send_absence_email_res = $this->sendAbsenceEmail(
        'absence',
        $request->co_worker_name,
        $request->date_called,
        $request->time_called,
        $this->returnDate($request->date_absence_for),
        $request->shift_start_time,
        $request->shift_end_time,
        $request->ref_number,
        $request->reason_option_selected_value,
        "",
        $comment,
        "",
        $subject,
        $emailTemplate,
        $request->co_worker_email
      );

      if ($send_absence_email_res["error"]) {
        return response()->json([
          'errors' => $this->returnGenericSystemErrMsg(),
          'error_code' => '08',
        ], 422);
      } //End if send_absence_email_res error

      //SEND EMAIL TO DEPARTMENT REPONSIBLES

      //get email address for the co-worker department responbles
      $responsibles_details = User::select('fname', 'lname', 'email')->where('department_company', $request->department_id)->where('is_leader', 1)->get();
      //check if  responsibles_details is found and send email
      if (!empty($responsibles_details)) {

        foreach ($responsibles_details as $detail) {
          //co-worker email check against responsibles email
          if ($detail->email != $request->co_worker_email) {
            $subject = "Absence call for " . $request->department;
            $send_absence_email_res = $this->sendAbsenceEmail(
              'responsible',
              $detail->fname . ' ' . $detail->lname,
              $request->date_called,
              $request->time_called,
              $this->returnDate($request->date_absence_for),
              $request->shift_start_time,
              $request->shift_end_time,
              $request->ref_number,
              $request->reason_option_selected_value,
              $request->work_related,
              $comment,
              $request->co_worker_name,
              $subject,
              $emailTemplate,
              $detail->email
            );

            if ($send_absence_email_res["error"]) {
              return response()->json([
                'errors' => [$this->returnGenericSystemErrMsg()],
                'error_code' => '09',
              ], 422);
            } //End if send_absence_email_res error
          } // end co-worker email check against responsibles
        } // end foreach

      } //end if result


      return response()->json([
        'errors' => []
      ], 201);
    } catch (\Exception $e) {
      //dd($e);
      return response()->json([
        'errors' => $this->returnGenericSystemErrMsg(),
        'error_code' => '07',
      ], 422);
    } // end try catch

  } //end store


  public function updateAbsenceResponsibleTold(Request $request)
  {

    //update absence

    try {
      $loggedin_user = Str::limit(Auth::user()->fname, 1, '.' . Auth::user()->lname);
      $array_data = array(
        'responsible_told' => $request->responsible_told,
        'responsible_told_by' => $loggedin_user,

      );

      Absence::where('id', $request->absence_id)->update($array_data);

      return response()->json([
        'error' => '',
        'success_data' => ['responsible_told' => $request->responsible_told, 'responsible_told_by' => $loggedin_user]
      ], 201);
    } catch (\Exception $e) {
      //dd($e);
      return response()->json([
        'errors' => $this->returnGenericSystemErrMsg(),
        'error_code' => '07',
      ], 422);
    } // end try catch

  } //end updateAbsenceResponsibleTold


}//end main class