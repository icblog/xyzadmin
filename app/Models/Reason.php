<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reason extends Model
{
    use HasFactory;
    
    public static function fetchReasons(){
   
        $outComeArray = array("error"=>false, "reasonResult"=> []);
      
      try {
             
        $outComeArray["reasonResult"] = DB::table('reasons')
                      ->select('name', 'quick_reason')
                      ->limit(15)
                      ->get();
      
          return $outComeArray;
      
        } catch (\Exception $e) {
         // dd($e);
          $outComeArray["error"] = true;
          return $outComeArray;
        }
       
      }//End fetchReasons

public static function visitingReasons(
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
   
      $out_come_array = array('error'=>false,'reasons_data'=>[]);
      
         try {
           
            $query = DB::table('reasons')
                     ->select('reasons.*','A.fname AS created_by_f','A.lname AS created_by_l','B.fname AS updated_by_f','B.lname AS updated_by_l')
                     ->leftjoin('users AS A','A.id','=','reasons.created_by')
                     ->leftjoin('users AS B','B.id','=','reasons.updated_by');
               
              if($reason  !=''){
                  $query->where([
                     ['name', 'LIKE', "%{$reason}%"]
                  ]);
               }
            $query->orderBy($order_by,$sort_how);
           if($paginate){
                  $out_come_array['reasons_data'] = $query->paginate($result_per_page);
                }else{
                  $out_come_array['reasons_data'] = $query->limit($result_per_page)
                  ->get();
                }
            
              return $out_come_array;
  
            } catch (\Exception $e) {
               //dd($e);
               $out_come_array['error'] = true;
               return $out_come_array;
  
            }
  
     }//End visitingReasons

}// end main class






