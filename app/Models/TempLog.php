<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class TempLog extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    //no created_at and updated_at columns in db
    public $timestamps = false;

    public static function findAllCurrentTempOffsite($orderBy = '')
    {

        switch ($orderBy) {
            case 'A-Z':
                $sortHow = "ASC";
                $orderBy =  "fname";
                break;
            case 'Z-A':
                $sortHow = "DESC";
                $orderBy =  "fname";
                break;
            case 'Date ascending':
                $sortHow = "ASC";
                $orderBy =  "time_out";
                break;

            case 'Date descending':
                $sortHow = "DESC";
                $orderBy =  "time_out";
                break;
            default:
                $sortHow = "DESC";
                $orderBy =  "id";
        }

        $outComeArray = array('error' => false, 'current_offsite_data' => []);

        try {
            $query = DB::table('temp_logs')

                ->select('id', 'fname', 'lname', 'depart_comp', 'time_out', 'time_in')
                ->whereNull('time_in')
                ->orderBy($orderBy, $sortHow);
            $outComeArray['current_offsite_data'] = $query->get();

            return $outComeArray;
        } catch (\Exception $e) {

            $outComeArray['error'] = true;
            return $outComeArray;
        }
    } // end findAllCurrentTempOffsite

    public static function findAllTempOffsite(
        $orderBy = "",
        $co_worker_visitor_fname = "",
        $start_date = "",
        $end_date = "",
        $has_date_changed = "no",
        $paginate = false,
        $result_per_page = 6
    ) {

        switch ($orderBy) {
            case 'A-Z':
                $sortHow = "ASC";
                $orderBy =  "fname";
                break;
            case 'Z-A':
                $sortHow = "DESC";
                $orderBy =  "fname";
                break;
            case 'Date ascending':
                $sortHow = "ASC";
                $orderBy =  "time_out";
                break;

            case 'Date descending':
                $sortHow = "DESC";
                $orderBy =  "time_out";
                break;
            default:
                $sortHow = "DESC";
                $orderBy =  "id";
        }

        $outComeArray = array('error' => false, 'temp_offsite_res_data' => []);

        try {

            $query = DB::table('temp_logs')

                ->select('id', 'fname', 'lname', 'depart_comp', 'time_out', 'time_in');

            if ($co_worker_visitor_fname != '') {
                $query->where([
                    ['fname', 'LIKE', "%{$co_worker_visitor_fname}%"]
                ])->orWhere([
                    ['lname', 'LIKE', "%{$co_worker_visitor_fname}%"]
                ]);
            }

            if ($has_date_changed == 'yes') {

                $query->whereDate('time_out', '>=', explode(" ", $start_date)[0])
                    ->whereDate('time_out', '<=', explode(" ", $end_date)[0]);
            }
            $query->orderBy($orderBy, $sortHow);


            if ($paginate) {
                $outComeArray['temp_offsite_res_data'] = $query->paginate($result_per_page);
            } else {
                $outComeArray['temp_offsite_res_data'] = $query->limit($result_per_page)
                    ->get();
            }

            return $outComeArray;
        } catch (\Exception $e) {
            //dd($e);
            $outComeArray['error'] = true;
            return $outComeArray;
        }
    }

    // public static function checkIfUserAlreadySignedOut($request)
    // {
    //     $outComeArray = array('error' => false, 'signed_out_id' => 0);
    //     $todayDate = now()->format('Y-m-d');

    //     try {
    //         $outComeResult = DB::table('temp_logs')
    //             ->select('id')
    //             ->where('fname', $request->fname)
    //             ->where('lname', $request->lname)
    //             ->whereNull('time_in')
    //             ->whereDate('time_out', '=', $todayDate)
    //             ->first();
    //         if (!is_null($outComeResult)) {
    //             $outComeArray['signed_out_id'] = $outComeResult->id;
    //         }

    //         return $outComeArray;
    //     } catch (\Exception $e) {
    //         //dd($e);
    //         $outComeArray['error'] = true;
    //         return $outComeArray;
    //     }
    // }

    // public static function offsiteSignOut($search_name)
    // {
    //     $outComeArray = array('error' => false, 'temp_sign_out_res' => []);
    //     $todayDate = now()->format('Y-m-d');
    //     try {
    //         $query = DB::table('temp_logs')->select('id', 'fname', 'lname');

    //         $query->where([
    //             ['lname', 'LIKE', "%{$search_name}%"]
    //         ]);

    //         $query->whereNull('time_in')->whereDate('time_out', '=', $todayDate);

    //         $outComeArray['temp_sign_out_res'] = $query->get();

    //         return $outComeArray;
    //     } catch (\Exception $e) {
    //         $outComeArray['error'] = true;
    //         return $outComeArray;
    //     }
    // }
}
