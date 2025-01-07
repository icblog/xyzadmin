<?php

namespace App\Http\Controllers\TempOffsite;

use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TempLog;

class TempOffsiteController extends BaseController
{

    public function index(Request $request)
    {
        $result_per_page = $this->returnResultPerPageNumber(); //Find this in base controller
        $paginate = true;
        $selected_sort_option = $request->has('selected_sort_option') ? $request->selected_sort_option : "";
        $co_worker_visitor_fname = $request->has('co_worker_visitor_fname') ? $request->co_worker_visitor_fname : "";
        $start_date = $request->has('start_date') ? $request->start_date : "";
        $end_date  = $request->has('end_date') ? $request->end_date : "";
        $has_date_changed = $request->has('has_date_changed') ? $request->has_date_changed : "no";

        $temp_offsite_res = TempLog::findAllTempOffsite(
            $selected_sort_option,
            $co_worker_visitor_fname,
            $start_date,
            $end_date,
            $has_date_changed,
            $paginate,
            $result_per_page
        );
        if ($temp_offsite_res['error']) {
            return redirect()
                ->route('viewtempoffsite.index')
                ->withErrors(["fail" => $this->returnGenericSystemErrMsg()])
                ->withInput();
        }

        return Inertia::render('tempoffsite/ViewTempOffsite', [
            'temp_offsite_res_data' => $temp_offsite_res['temp_offsite_res_data'],
        ]);
    } //end index

    public function currentTempOffsiteIndex(Request $request)
    {

        $current_temp_offsite = TempLog::findAllCurrentTempOffsite();

        if ($current_temp_offsite['error']) {
            return redirect()
                ->route('currenttempoffsite.index')
                ->withErrors(["fail" => $this->returnGenericSystemErrMsg()])
                ->withInput();
        }

        return Inertia::render('tempoffsite/CurrentTempOffsite', [
            'current_temp_offsite_res' => $current_temp_offsite['current_offsite_data'],

        ]);
    } //end currentTempOffsiteIndex

    public function sortCurrentTempOffsite(Request $request)
    {

        if (!is_string($request->selected_sort_option)) {
            return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
            ]);
        } //End if 
        $current_temp_offsite = TempLog::findAllCurrentTempOffsite($request->selected_sort_option);

        if ($current_temp_offsite['error']) {
            return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
            ]);
        }

        return response()->json([
            'error' => "",
            'current_temp_offsite_res' => $current_temp_offsite['current_offsite_data'],
        ]);
    } // end sortCurrentTempOffsite 
    public function tempOffsiteSignIn(Request $request)
    {
        if (!is_numeric($request->signed_out_id)) {
            return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
            ]);
        } //End if   
        try {
            //if there is an id update database;
            $outcome = TempLog::where('id', $request->signed_out_id)
                ->update(['time_in' => $request->current_date_time]);

            return response()->json([
                'error' => ''
            ]);
        } catch (\Exception $e) {
            //dd($e);
            return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
            ]);
        } // end try catch
    } //end tempOffsiteSignIn

}//end main class