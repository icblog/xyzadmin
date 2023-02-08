<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class ResetPasswordController extends BaseController{
  //METHODS USED FROM HELPER TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
 // returnGenericSystemErrMsg
 //returnLinkErrMsg

//METHODS USED FROM TOKEN TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
//genarateToken
//deCorded
private function setResetPasswordLinkSession($redirectReason,$request,$redirectUrl="/"){
   $msg = $this->returnLinkErrMsg();

  if($redirectReason == "systemErr"){
    $msg = $this->returnGenericSystemErrMsg();
  }

  if($redirectReason == "linkErr" || $redirectReason == "systemErr"){
    $this->setNotificationSessionData(
      $redirectUrl,
      "error",
      $msg,
      4000,
      $request
    );
   }

   if($redirectReason == "resetSuccess"){
    $this->setNotificationSessionData(
      '/login',
      "success",
      "Password reset successful, please login",
      1500,
      $request
    );
   }


   return redirect("/notification");
   die();
}
    

public function index(Request $request){
      
        return Inertia::render('auth/ResetPassword');
}// end index
  
    public function update(Request $request){
      $redirectUrl = '/forgotten-password';
      $tk = "";
       
      if ($request->session()->has('tk')) {
          $tk = $request->session()->get('tk');
          
         }else{
          return $this->setResetPasswordLinkSession("linkErr",$request,$redirectUrl);
         
        }//End if session has tk
  
      //Check if the hidden recaptcha input is filled in,
        //if so it a human that filled it in, throw an error.
        if($request->myhouse != ''){
          return redirect()->route('home.index');
          die();
       }

         $validator = Validator::make($request->all(), [
              'password'=>'required|string|min:8',
          ]); 
      
           if ($validator->fails()) {
            return redirect()
            ->route('resetPass.index')
            ->withErrors($validator)
            ->withInput();
             die();
          }//end if validation
      
           //DECODE AND VERIFY THE TOKEN
          $verifyRes = $this->decodeToken($tk);
      
        if($verifyRes["msg"] == "Good"){
             //Get email data from token 
           $email = $verifyRes["data"]->email;
              //Hash and update password
           $hashPassword = Hash::make($request->password);
           try {
            User::where('email', $email)->update(['password' => $hashPassword,'what_was_change' => 'Password', 'token_status'=>'yes']);
            
            $request->session()->forget('tk');

            return $this->setResetPasswordLinkSession("resetSuccess",$request,'/login');

         } catch (\Exception $e) {

          return $this->setResetPasswordLinkSession("systemErr",$request,$redirectUrl);
         }
    }else if($verifyRes["msg"] == "Invalid"){
      return $this->setResetPasswordLinkSession("linkErr",$request,$redirectUrl);

    }else{
      return $this->setResetPasswordLinkSession("systemErr",$request,$redirectUrl);
    }
      
}//End update


}//end class
