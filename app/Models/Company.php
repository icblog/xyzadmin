<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    //protected $table = 'companies';


    public static function fetchCompanies(){
   
        $outComeArray = array("error"=>false, "companyResult"=> []);
      
      try {
             
        $outComeArray["companyResult"] = DB::table('companies')
                      ->select('name', 'quick_company')
                      ->limit(15)
                      ->get();
      
          return $outComeArray;
      
        } catch (\Exception $e) {
         // dd($e);
          $outComeArray["error"] = true;
          return $outComeArray;
        }
       
      }//End fetchCompanies


}






