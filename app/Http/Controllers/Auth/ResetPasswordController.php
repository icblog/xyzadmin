<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\BaseController;
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
  
  $isSystem_pass_used = "no";

  if ($request->session()->has('system_pass')) {
   $isSystem_pass_used = $request->session()->get('system_pass', '');
  
  }
  return Inertia::render('auth/ResetPassword',['systemPassUsed'=> $isSystem_pass_used]);
}// end index
  
private function handleResetPasswordLink($request){
      $redirectUrl = '/forgotten-password';
      $tk = "";
       
      if ($request->session()->has('tk')) {
          $tk = $request->session()->get('tk');
          
         }else{
          return $this->setResetPasswordLinkSession("linkErr",$request,$redirectUrl);
         
        }//End if session has tk
  
   
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

           //Get email data from token 
           $email = $verifyRes["data"]->email;
          
           //Hash and update password
           $hashPassword = Hash::make($request->password);
           try {
            User::where('email', $email)->update(['password' => $hashPassword,'what_was_change' => 'Password', 'using_system_pass'=>'no']);
            
            $request->session()->forget('tk');

            $request->session()->put('respondsMsg', "code200");
          return redirect()
           ->route('resetPass.index');
          die();

         } catch (\Exception $e) {
          return redirect()
          ->route('resetPass.index')
          ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
          ->withInput();
         }
    
      
}//End update

private function handleResetSystemPassUsed($request){
 
  //Custom attribute names
  $attributeNames = array(
    'password' => 'new password',
    'oldpassword' => 'old password',
  );

  $validator = Validator::make($request->all(), [
    'password'=>'required|string|min:8',
    'oldpassword'=>'required|string|min:8',
]);
     //Use custom attributes names for error reporting
     $validator->setAttributeNames($attributeNames); 

      if ($validator->fails()) {
        return redirect()
        ->route('resetPass.index')
        ->withErrors($validator)
        ->withInput();
        die();
      }//end if validation

      //Update database and current session.
        //Check if old password matches database password
      if (Hash::check($request->oldpassword, Auth::user()->password)) { 
        //Hashed new password and update db
        $hashPassword = Hash::make($request->password);
        $userEmail = Auth::user()->email;
        try {
          User::where('id', Auth::user()->id)->update(['using_system_pass' => 'no','password' =>  $hashPassword]);
          
          $request->session()->put('system_pass', 'no');
          
          $request->session()->put('respondsMsg', "code200");
          return redirect()
           ->route('resetPass.index');
          die();
        
        } catch (\Exception $e) {
          return redirect()
          ->route('resetPass.index')
          ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
          ->withInput();
        }
        
      }else{
        return redirect()
        ->route('resetPass.index')
        ->withErrors(["fail"=> "We can not find you if that information, please try again"])
        ->withInput();
        
      }

}

public function handleResetPassword(Request $request){
     //Check if myhouse the hidden recaptcha input is filled in,
        //if that is the case redirect to home page.
         if($request->myhouse != ''){
          return redirect()->route('home.index');
          die();
      }

    if($request->systemPassUsed == 'yes'){
       $this->handleResetSystemPassUsed($request);
    }else if($request->systemPassUsed == 'no'){
      $this->handleResetPasswordLink($request);
    }else{
      return redirect()->route('home.index');
      die();
    }

}


}//end class
