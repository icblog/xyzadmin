<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class KeyStorage extends Model{
    use HasFactory;


    public static function allStorage(
        $order_by = '',
        $storage = "",
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
   
      $out_come_array = array('error'=>false,'key_storage_data'=>[]);
      
         try {
           
            $query = DB::table('key_storages')
                     ->select('key_storages.*','A.fname AS created_by_f','A.lname AS created_by_l','B.fname AS updated_by_f','B.lname AS updated_by_l')
                     ->leftjoin('users AS A','A.id','=','key_storages.created_by')
                     ->leftjoin('users AS B','B.id','=','key_storages.updated_by');
               
              if($storage  !=''){
                  $query->where([
                     ['name', 'LIKE', "%{$storage}%"]
                  ]);
               }
            $query->orderBy($order_by,$sort_how);
           if($paginate){
                  $out_come_array['key_storage_data'] = $query->paginate($result_per_page);
                }else{
                  $out_come_array['key_storage_data'] = $query->limit($result_per_page)
                  ->get();
                }
            
              return $out_come_array;
  
            } catch (\Exception $e) {
              // dd($e);
               $out_come_array['error'] = true;
               return $out_come_array;
  
            }
  
     }//End allStorage

    
}//End class




