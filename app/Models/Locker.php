<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Locker extends Model{
    use HasFactory;
    


public static function fetchLockers(
        $filer_by = '',
        $locker_name = "",
        $paginate=false,
        $result_per_page=6
        ){
       
      $out_come_array = array('error'=>false,'lockers_data'=>[]);
      
         try {
           
            $query = DB::table('lockers')
                     ->select('lockers.*','A.fname AS created_by_f','A.lname AS created_by_l','B.fname AS updated_by_f','B.lname AS updated_by_l','C.fname AS belongs_f','C.lname AS belongs_l')
                     ->leftjoin('users AS A','A.id','=','lockers.created_by')
                     ->leftjoin('users AS B','B.id','=','lockers.updated_by')
                     ->leftjoin('users AS C','C.locker','=','lockers.id');
                     if($locker_name  !=''){
                        $query->where([
                           ['name', 'LIKE', "%{$locker_name}%"]
                        ]);
                     }
              
                     if($filer_by == 'Free'){
                       $query->where('locker_status',0);
                     }

                     if($filer_by  == 'Inuse'){
                        $query->where('locker_status',1);
                      }

                      if($filer_by == 'Broken'){
                        $query->where('locker_status',2);
                      }

                      $query->orderBy('id','DESC');
           
            
           if($paginate){
                  $out_come_array['lockers_data'] = $query->paginate($result_per_page);
                }else{
                  $out_come_array['lockers_data'] = $query->limit($result_per_page)
                  ->get();
                }
            
              return $out_come_array;
  
            } catch (\Exception $e) {
               //dd($e);
               $out_come_array['error'] = true;
               return $out_come_array;
  
            }
  
     }//End fetchLokers

}// end main class






