<?php

namespace App\Http\Controllers;
use App\Traits\HelperTrait;
use App\Traits\TokenTrait;
use App\Models\User;
use App\Lib\Cloudinary;

class BaseController extends Controller{
   
    use HelperTrait;
    use TokenTrait;
     //METHODS USED FROM HelperTrait
     //sendAlinkToUser
    
   public $linkExpireTime = 2400;//(40mins)

public function cloudinaryInstance(){
      $cloudinary = new Cloudinary();
      return  $cloudinary;
}//End cloudinaryInstance


 public function sendPasswordWordResetLink($token, $email){

     try {
            
       User::where('email', $email)->update(['token_status' => 'no','what_was_change' => 'Token status']);
       $action = "secure2";
       $subject ="About your account";
       $emailTemplate = "mail.reg-email-exist";
       return $this->sendAlinkToUser($token, $email, $action, $subject, $emailTemplate);
       
    } catch (\Exception $e) {
     
         return ["error" => true];
     
    }
  }//End sendPasswordWordResetLink
  
public function setNotificationSessionData(
           $redirectLink,
           $type,
           $msg,
           $redirectTime,
           $request
           ){
          $request->session()->put('redirectLink', $redirectLink);
          $request->session()->put('type', $type);
          $request->session()->put('msg', $msg);
          $request->session()->put('redirectTime', $redirectTime);

}//End setNotificationSessionData

public function returnCloudinaryDefaultLink(){
  return "https://res.cloudinary.com/icblog254/image/upload/v1662665884/icblog/siteimgs/vqkopmclbqxlbtfk9b59.png";
}

    

}//End class
