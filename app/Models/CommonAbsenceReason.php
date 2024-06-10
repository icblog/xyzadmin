<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CommonAbsenceReason extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    //protected $table = 'common_absence_reasons';


    public static function fetchCommonAbsenceReason($whereColumn="",$whereValue="",$whereOperator=""){
   
        $outComeArray = array("error"=>false, "caReasonResult"=> []);
      
      try {
             
        $query = DB::table('common_absence_reasons')
                      ->select('id', 'name');
                     if($whereValue !=""){
                        $outComeArray["caReasonResult"] = $query->whereDate($whereColumn, $whereOperator, $startDate)->first();
                      }else{
                        $outComeArray["caReasonResult"] = $query->get();
                      }
          
         return $outComeArray;
      
        } catch (\Exception $e) {
         // dd($e);
          $outComeArray["error"] = true;
          return $outComeArray;
        }
       
      }//End fetchCommonAbsenceReason


public static function absenceReasons(
        $order_by = '',
        $reason = "",
        $paginate=false,
        $result_per_page=6
        ){
           
      switch ($order_by) {
         case 'A-Z':
            $sort_how = "ASC";
            $order_by =  "name";
             break;
         case 'Z-A':
            $sort_how = "DESC";
            $order_by =  "name";
             break;
         case 'Date ascending':
             $sort_how = "ASC";
             $order_by =  "created_at";
             break;
  
         case 'Date descending':
            $sort_how = "DESC";
            $order_by =  "created_at";
            break;
       default:
         $sort_how = "DESC";
         $order_by =  "id";
     }
   
      $out_come_array = array('error'=>false,'absence_reason_data'=>[]);
      
         try {
           
            $query = DB::table('common_absence_reasons')
                     ->select('common_absence_reasons.*','A.fname AS created_by_f','A.lname AS created_by_l','B.fname AS updated_by_f','B.lname AS updated_by_l')
                     ->leftjoin('users AS A','A.id','=','common_absence_reasons.created_by')
                     ->leftjoin('users AS B','B.id','=','common_absence_reasons.updated_by');
               
              if($reason  !=''){
                  $query->where([
                     ['name', 'LIKE', "%{$reason}%"]
                  ]);
               }
            $query->orderBy($order_by,$sort_how);
           if($paginate){
                  $out_come_array['absence_reason_data'] = $query->paginate($result_per_page);
                }else{
                  $out_come_array['absence_reason_data'] = $query->limit($result_per_page)
                  ->get();
                }
            
              return $out_come_array;
  
            } catch (\Exception $e) {
               //dd($e);
               $out_come_array['error'] = true;
               return $out_come_array;
  
            }
  
     }//End absenceReasons


}






