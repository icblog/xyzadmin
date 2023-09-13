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


}






