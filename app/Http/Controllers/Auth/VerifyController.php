<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\BaseController;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class VerifyController extends BaseController{
    //METHODS USED FROM HELPER TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
 // returnGenericSystemErrMsg
 //returnLinkErrMsg
 //checkIsEmail

//METHODS USED FROM TOKEN TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
//genarateToken
//deCorded

public function index(Request $request){
       // $action = $request->action;
        $token = $request->tk;
        if ($token == ""){
               return redirect()->route('home.index');
               die();
        }
       $request->session()->put('tk', $token);
        
      return Inertia::render('auth/Verify');
       
  }

  public function verifyLink(Request $request){
       $token = "";
      
       if ($request->session()->has('tk')) {
        $token = $request->session()->get('tk');
       }
      
       //DECODE AND VERIFY THE TOKEN
      $verifyRes = $this->decodeToken($token);

       if($verifyRes["msg"] == "Good"){
            $email = $verifyRes["data"]->email;
             //Check to unsure is email
               if (!$this->checkIsEmail($email)) {
                return redirect()->route('home.index');
                die();
              }
               //check if link has already been used in DB.
               $userOutCome = User::checkIfUserExist('email',$email);
               //check if the user outcome is error
               if($userOutCome["error"]){
                //Find this method above
                $request->session()->put('respondsMsg', "code000");
                return redirect()->route('verify.index',[$token]);
              }//End if out come error

                if(!is_null($userOutCome["user"])){
                   //Check the value of token status
                   $userRes =  $userOutCome["user"];
                    if($userRes->token_status == "no"){
                       //All good update token status field in db to yes
                       User::where('id',$userRes->id)->update(['token_status' => 'yes','what_was_change' => 'Token status']);
                       return redirect()->route('resetPass.index');
                    }else{
                     //Token already used 
                     $request->session()->put('respondsMsg', "code000");
                     return redirect()->route('verify.index',[$token]);
                       
                    }// end  if $userRes->token_status == 'no'
             
                }else{

                  $request->session()->put('respondsMsg', "code000");
                  return redirect()->route('verify.index',[$token]);   
                  
            }//End if useroutcome is not empty

        }else if($verifyRes["msg"] == "Invalid"){
           
          $request->session()->put('respondsMsg', "code000");
          return redirect()->route('verify.index',[$token]);
         
      }else{
          
           $request->session()->put('respondsMsg', "code000");
           return redirect()->route('verify.index',[$token]);
       
      }

    }// End verifyLink

}//end class
