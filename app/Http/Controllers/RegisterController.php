<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends BaseController{

//METHODS USED FROM HELPER TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
//returnGenericSystemErrMsg

//METHODS USED FROM TOKEN TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
//genarateToken

private function setRegisterLinkSession($redirectReason,$request,$redirectUrl="/"){
  
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
    
    if($redirectReason == "initiaRegister" || 'passwordResetMailSent'){
      $msg = "Please check your email and follow the instruction to continue thank you"; 
      $this->setNotificationSessionData(
         '/',
         "info",
          $msg,
         5000,
         $request
       );  
 
     }

     if($redirectReason == "registerSuccess"){
      $msg = "Account created successfully, logging you in....."; 
      $this->setNotificationSessionData(
         $redirectUrl,
         "success",
          $msg,
         2000,
         $request
       );  
 
     }

     
    
   return redirect("/notification");
    die();
 }
    
    
    public function index(){
        
        return Inertia::render('auth/InitiaRegister');
        
    }// end index


  public function completeRegister(){
    return Inertia::render('auth/CompleteRegister');
      
  }// end index

  public function handleInitialRegister(Request $request){
       //Check if mmyhouse the hidden recaptcha input is filled in,
        //if that is the case redirect to home page.
        
        if($request->myhouse != ''){
            return redirect()->route('home.index');
            die();
        }

        $action = "";
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email'
        ]);

        if ($validator->fails()) {
            return redirect()
            ->route('register.index')
            ->withErrors($validator)
            ->withInput();
            die();
        }

      //Check if user exist if so send the a link to reset their password if not send a link to verify email and feedback to ajax.
      
      $userOutCome = User::checkIfUserExist('email',$request->email);
      //check if the user outcome is error
      if($userOutCome["error"]){
      return $this->setRegisterLinkSession("systemErr",$request);
    }//End if out come error

       //Generate token
        $tokenData = array('email' => $request->email);
        $token = $this->genarateToken($this->linkExpireTime,$tokenData);

        //if user exist, send a password reset link.
      //if not send verify link to user email.

      if($userOutCome["user"] == ""){
            $action = "secure1";
            $subject ="About your registration";
            $emailTemplate = "mail.new-account";
            $sendLinkOutCome = $this->sendAlinkToUser($token,$request->email,$action,$subject,$emailTemplate);
        
     }else{
         
            $sendLinkOutCome = $this->sendPasswordWordResetLink($token, $request->email);
           
     }//End if user is empty

       if($sendLinkOutCome["error"]){
        
        return $this->setRegisterLinkSession("systemErr",$request);
       }//End if out come error
        
      
      return $this->setRegisterLinkSession("initiaRegister",$request);
    
}// end initialRegister

public function handleCompleteRegister(Request $request){
  $redirectUrl = '/complete-register';
  $tk = "";
   
  if ($request->session()->has('tk')) {
      $tk = $request->session()->get('tk');
      
     }else{
      return $this->setRegisterLinkSession("linkErr",$request,$redirectUrl);
     
    }//End if session has tk
 
 
  //Check if mmyhouse the hidden recaptcha input is filled in,
        //if that is the case redirect to home page.
        
        if($request->myhouse != ''){
            return redirect()->route('home.index');
            die();
        }



$validator = Validator::make($request->all(), [
   'username'=>'required|string|unique:users',
   'password'=>'required|string|min:8',

]); 


if ($validator->fails()) {
    return redirect()
    ->route('register.complete.index')
    ->withErrors($validator)
    ->withInput();
    die();
   }//end if validation

 //DECODE AND VERIFY THE TOKEN
 $verifyRes = $this->decodeToken($tk);

 if($verifyRes["msg"] == "Good"){
  //Get email data from token 
$email = $verifyRes["data"]->email;

try {
  $user = User::where('email', $email)->first();
   if($user){
     //If user send email for them to reset their password

         //Generate token
      $tokenData = array('email' => $email);
      $token = $this->genarateToken($this->linkExpireTime,$tokenData);//expire time in seconds(10mins)
      $sendLinkOutCome = $this->sendPasswordWordResetLink($token, $request->email);
      if($sendLinkOutCome["error"]){
        return $this->setRegisterLinkSession("systemErr",$request);
       }//End if out come error
       $request->session()->forget('tk');
         return $this->setRegisterLinkSession("passwordResetMailSent",$request);
  
       }else{

         //Register the user and log them in auto

               $user = new User();
                $user->email = $email;
                $user->username = $request->username;
                $user->token_status = "yes";
                $user->password = Hash::make($request->password);
                $user->uip = $request->ip();
                $user->save();

               $credentials = array(
                  'email' => $email,
                  'password' => $request->password
                );

                Auth::attempt($credentials);

                User::updateLastLoginDate();
               $request->session()->regenerate();
                
               $defaultUrl = route("blog.index",["post","latest"],false);//route name
                 if(Auth::user()->role == 1){
                  $defaultUrl = route("admin.dashboard",[],false);
                 }
                 //Intended url is stored in session by admin middleware located in the middleware folder 
                 $defaultUrl = $this->replaceFirstOccuranceOfChar("/","",$defaultUrl);
                 $intendedUrl =  $request->session()->pull('intendedUrl', $defaultUrl);
                
                 $request->session()->forget('tk');
                 return $this->setRegisterLinkSession("registerSuccess",$request,$defaultUrl);
      }//End if user


} catch (\Exception $e) {

return $this->setRegisterLinkSession("systemErr",$request,$redirectUrl);
}
}else if($verifyRes["msg"] == "Invalid"){
return $this->setRegisterLinkSession("linkErr",$request,$redirectUrl);

}else{
return $this->setRegisterLinkSession("systemErr",$request,$redirectUrl);
}

}//End method handleCompleteRegister
   
}//end class
