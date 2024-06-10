<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Absence extends Model{
    use HasFactory;



//old
// public static function fetchCoworkerDepartResponsiblePhone($department_id){
//     $out_come_array = array("error"=>false, "result"=> []);
  
//   try {
//     $query =  DB::table('department_and_companies')  
//     //->select('departments.name','A.phone','A.description','B.fname','B.lname',DB::raw('group_concat(DISTINCT A.phone) as depart_phones,group_concat(DISTINCT A.description) as depart_phones_desc,group_concat(DISTINCT B.fname) as responsible_fname,group_concat(DISTINCT B.lname) as responsible_lname'))
//     ->select('department_and_companies.name',DB::raw('group_concat(DISTINCT B.email," ",B.fname," ",B.lname) AS responsible_names, group_concat(DISTINCT A.description,": "," ",A.phone) as depart_phones'))
//     ->join('phones AS A', 'A.depart_comp_id', '=', 'department_and_companies.id')
//     ->join('users AS B', 'B.department', '=', 'department_and_companies.id')
//     ->where('department_and_companies.id',  $department_id);
//     $out_come_array['result'] = $query->get();
  
//      //dd($out_come_array['result']);
//       return $out_come_array;
  
//     } catch (\Exception $e) {
//        //dd($e);
//       $out_come_array["error"] = true;
//       return $out_come_array;
//     }
   
// }//End fetchCoworkerDepartResponsiblePhone

   public static function viewAllAbsence(
      $order_by='',
      $coworker_name="",
      $start_date="", 
      $end_date="",
      $is_date_changed="no",
      $department_id="",
      $work_related="",
      $paginate=false,
      $result_per_page=6
      ){
         
    switch ($order_by) {
       case 'A-Z':
          $sort_how = "ASC";
          $order_by =  "co_worker_name";
           break;
       case 'Z-A':
          $sort_how = "DESC";
          $order_by =  "co_worker_name";
           break;
       case 'Date ascending':
           $sort_how = "ASC";
           $order_by =  "date_for";
           break;

       case 'Date descending':
          $sort_how = "DESC";
          $order_by =  "date_for";
          break;
     default:
       $sort_how = "DESC";
       $order_by =  "id";
   }
 
    $out_come_array = array('error'=>false,'view_all_absence_data'=>[]);
    
       try {
         
          $query = DB::table('absences')
           
            ->select('absences.id','absences.ref_number','absences.co_worker_name','absences.reason','absences.comment','absences.work_related','absences.date_for','absences.shift_start_time','absences.shift_end_time','absences.responsible_told','absences.logged_by','absences.responsible_told_by','absences.created_at','department_and_companies.name AS department_name','department_and_companies.id AS department_id')
            ->join('department_and_companies','department_and_companies.id','=','absences.depart_comp_id');
             
            if($coworker_name !=''){
                $query->where([
                   ['co_worker_name', 'LIKE', "%{$coworker_name}%"]
                ]);
             }

            
             if($is_date_changed =='yes'){
             
               $query->whereDate('date_for', '>=',explode(" ",$start_date)[0])
                ->whereDate('date_for', '<=', explode(" ",$end_date)[0]);
             }

             if($department_id !=''){
              $query->where('absences.depart_comp_id',  $department_id);
             }
             if($work_related !=''){
               $query->where('absences.work_related',  $work_related);
              }

             

             $query->orderBy($order_by,$sort_how);

             
             if($paginate){
                $out_come_array['view_all_absence_data'] = $query->paginate($result_per_page);
              }else{
                $out_come_array['view_all_absence_data'] = $query->limit($result_per_page)
                ->get();
              }
          
            return $out_come_array;

          } catch (\Exception $e) {
             //dd($e);
             $out_come_array['error'] = true;
             return $out_come_array;

          }

   }//End view all absence

}//End class




