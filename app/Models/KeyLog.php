<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class KeyLog extends Model {
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    //no created_at and updated_at columns in db
    public $timestamps = false;

    public static function showAllKeyLogData($order_by = '', $key_name = "", $start_date = "", $end_date = "", $has_date_changed = "no", $paginate = false, $result_per_page = 6)
    {
          $filter_key_out = "";
        if($order_by == 'Key out'){
            $filter_key_out =  $order_by;
            $how_to_sort = "ASC";
            $order_by =  "id";
        }else{
            
            switch ($order_by) {
                case 'A-Z':
                    $how_to_sort = "ASC";
                    $order_by =  "key_name";
                    break;
                case 'Z-A':
                    $how_to_sort = "DESC";
                    $order_by =  "key_name";
                    break;
                case 'Date ascending':
                    $how_to_sort = "ASC";
                    $order_by =  "out_at";
                    break;
    
                case 'Date descending':
                    $how_to_sort = "DESC";
                    $order_by =  "out_at";
                    break;
                
                default:
                    $how_to_sort = "DESC";
                    $order_by =  "id";
              }// end switch

            }//end if
        

        $outComeArray = array('error' => false, 'key_log_data' => []);

        try {

            $query = DB::table('key_logs')->select('*');

            if ($key_name != '') {
                $query->where([
                    ['key_name', 'LIKE', "%{$key_name}%"]
                ]);
            }

            if ($has_date_changed == 'yes') {
                $query->whereDate('out_at', '>=', explode(" ", $start_date)[0])
                    ->whereDate('out_at', '<=', explode(" ", $end_date)[0]);
            }

            if($filter_key_out != ''){
                $query->where('in_at', Null);
            }
            $query->orderBy($order_by, $how_to_sort);


            if ($paginate) {
                $outComeArray['key_log_data'] = $query->paginate($result_per_page);
            } else {
                $outComeArray['key_log_data'] = $query->limit($result_per_page)
                    ->get();
            }

         return $outComeArray;
        } catch (\Exception $e) {
            //dd($e);
            $outComeArray['error'] = true;
            return $outComeArray;
        }
    }
}// End main class