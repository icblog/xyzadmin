<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable{
    

 public static function updateLastLoginDate(){
  if (Auth::check()){
    DB::table('users')->where('id', Auth::User()->id)->update(['last_login_date' => \Carbon\Carbon::now()->toDateTimeString()]);
  }
}


public static function checkIfUserExist($fieldTocheck,$fieldValue){
    $outComeArray = array("error" => false, "user" => null);
  
  try {
  
     $user = DB::table('users')->where($fieldTocheck, $fieldValue)->first();
  
     $outComeArray["user"] = $user;

    //  if(!is_null($user)) {
    //     $outComeArray["user"] = $user;
    //  }
  
     return $outComeArray;
  
    } catch (\Exception $e) { 
      $outComeArray["error"] = true;
      return $outComeArray;
    }
   
}//End check if user exist

public static function searchUser($searchedWord){
  $outComeArray = array("error"=>false, "searchResult"=> []);

try {
       
  $outComeArray["searchResult"] = DB::table('users')
                
                ->select('fname','lname','phone','email')
                ->where([
                  ['fname', 'LIKE', "%{$searchedWord}%"]
                ])
                ->orWhere([
                  ['lname', 'LIKE', "%{$searchedWord}%"]
                ])
                ->limit(5)
                ->get();

    return $outComeArray;

  } catch (\Exception $e) {
     //dd($e);
    $outComeArray["error"] = true;
    return $outComeArray;
  }
 
}//End searchUser


}
