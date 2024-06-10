<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Phones extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    //protected $table = 'phones';

public static function fetchPhonesAndDepartments(){
   
        $out_come_array = array("error"=>false, "result"=> []);

        try { 
        
           $query = DB::table('department_and_companies')
                    
                    ->select('department_and_companies.name','department_and_companies.email', DB::raw('group_concat(DISTINCT A.description,": "," ",A.phone) as depart_phones'))
                    ->leftjoin('phones AS A','A.depart_comp_id','=','department_and_companies.id')
                    ->groupBy('department_and_companies.id')
                    ->orderBy('department_and_companies.name','ASC');
                   $out_come_array["result"] = $query->get();

          return $out_come_array;
      
        } catch (\Exception $e) {
          //dd($e);
          $out_come_array["error"] = true;
          return $out_come_array;
        }
}//End fetchPhonesAndDepartments



}// end main class