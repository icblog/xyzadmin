<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DepartmentAndCompany extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
 


    public static function fetchDepartmentsAndCompanies($where_column="",$where_value="",$where_operator="", $single_res = false){
   
        $out_come_array = array("error"=>false, "departmentResult"=> []);
      
      try { 
        
           $query = DB::table('department_and_companies')->select('id', 'name');
         
           if($where_column != ""){
            $query->where($where_column, $where_operator, $where_value);
          }
          $query->orderBy('department_and_companies.name','ASC');

          if($single_res){
            $out_come_array["departmentResult"] = $query->first();
          }else{
            $out_come_array["departmentResult"] = $query->get();
          }
            
      
          return $out_come_array;
      
        } catch (\Exception $e) {
         // dd($e);
          $out_come_array["error"] = true;
          return $out_come_array;
        }
       
      }//End fetchDepartmentsAndCompanies


public static function fetchDepartmentsWithAbsentCount(){
   
        $out_come_array = array("error"=>false, "department_result"=> []);

        try { 
        
           $query = DB::table('department_and_companies')
                    
                    ->select('department_and_companies.id', 'department_and_companies.name', DB::raw('count(absences.depart_comp_id) as department_absence_total'))
                    
                    ->leftJoin('absences', function($join) {
                      $join->on('absences.depart_comp_id', '=', 'department_and_companies.id')
                      ->whereDate('absences.date_for', '=', Carbon::today());
                     })
                    ->where('is_depart_or_comp','=', 0)
                    ->groupBy('department_and_companies.id')
                    ->orderBy('department_and_companies.name','ASC');
                   $out_come_array["department_result"] = $query->get();

          return $out_come_array;
      
        } catch (\Exception $e) {
          //dd($e);
          $out_come_array["error"] = true;
          return $out_come_array;
        }

}//End fetchDepartmentsWithAbsentCount


public static function fetchDepartmentsWithCoWorkerCount(){
   
  $out_come_array = array("error"=>false, "depart_coworker_count_result"=> []);

  try { 
  
     $query = DB::table('department_and_companies')
              
              ->select('department_and_companies.id', 'department_and_companies.name', DB::raw('count(users.department_company) as department_user_total'))
              
              ->leftJoin('users', function($join) {
                $join->on('users.department_company', '=', 'department_and_companies.id');
               })
              ->where('is_depart_or_comp','=', 0)
              ->groupBy('department_and_companies.id')
              ->orderBy('department_and_companies.name','ASC');
             $out_come_array["depart_coworker_count_result"] = $query->get();

    return $out_come_array;

  } catch (\Exception $e) {
    //dd($e);
    $out_come_array["error"] = true;
    return $out_come_array;
  }

}//End fetchDepartmentsWithCoWorkerCount



public static function viewAllDepartmentCompany(
  $sort_by='',
  $searched_word="",
  $paginate=false,
  $result_per_page=6
  ){

 $department = "";
 $company = "";   
     
switch ($sort_by) {
   case 'A-Z':
      $sort_how = "ASC";
      $sort_by =  "name";
       break;
   case 'Z-A':
      $sort_how = "DESC";
      $sort_by =  "name";
       break;
   case 'Department':
       $department = 0;
       $sort_how = "ASC";
       $sort_by =  "name";
       break;

   case 'Company':
      $company = 1;
      $sort_how = "ASC";
      $sort_by =  "name";
      break;
 default:
   $sort_how = "DESC";
   $sort_by =  "id";
}

$out_come_array = array('error'=>false,'view_all_departcomp_data'=>[]);

   try {
     
      $query = DB::table('department_and_companies')
               ->select('department_and_companies.id','department_and_companies.name','department_and_companies.email','department_and_companies.is_depart_or_comp', 'department_and_companies.is_quick','department_and_companies.created_at','department_and_companies.updated_at','department_and_companies.created_by','A.fname AS created_f_name','A.lname AS created_l_name','B.fname AS updated_f_name','B.lname AS updated_l_name')
               ->leftjoin('users AS A','A.id','=','department_and_companies.created_by')
               ->leftjoin('users AS B','B.id','=','department_and_companies.updated_by');
      
    if($searched_word !=''){
                $query->where([
                   ['name', 'LIKE', "%{$searched_word}%"]
                ]);
     }
     
      
     if($department === 0){
      
           $query->where('department_and_companies.is_depart_or_comp', $department);
       }

       if($company === 1){
        $query->where('department_and_companies.is_depart_or_comp', $company);
       }

    $query->orderBy($sort_by,$sort_how);

   if($paginate){
            $out_come_array['view_all_departcomp_data'] = $query->paginate($result_per_page);
    }else{
     $out_come_array['view_all_departcomp_data'] = $query->limit($result_per_page)
      ->get();
  }
      
        return $out_come_array;

      } catch (\Exception $e) {
        // dd($e);
         $out_come_array['error'] = true;
         return $out_come_array;

      }

}//End viewAllDepartmentCompany


public static function fetchCoWorkersByDepartment($depart_id){
   
  $out_come_array = array("error"=>false, "depart_coworker_results"=> []);

  try { 
  
              $query = DB::table('users')
              ->select('fname', 'lname','department', 'role', 'created_at')
              ->where('department',$depart_id)
              ->orderBy('fname','ASC');
             $out_come_array["depart_coworker_results"] = $query->get();

    return $out_come_array;

  } catch (\Exception $e) {
    //dd($e);
    $out_come_array["error"] = true;
    return $out_come_array;
  }

}


}






