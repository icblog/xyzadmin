<?php

namespace App\Http\Controllers;

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


private function setVerifyLinkSession($redirectName,$request,$redirectLink="/"){
  
  $linkOrErrorMsg = $this->returnLinkErrMsg();
   if($redirectName == "link_issue_dberr"){
    $linkOrErrorMsg = $this->returnGenericSystemErrMsg();
   }

    if($redirectName == "home" 
        || $redirectName == "link_issue"
        || $redirectName == "link_issue_dberr"){
        $this->setNotificationSessionData(
        $redirectLink,
        "error",
        $linkOrErrorMsg,
        5000,
        $request
      );
    }//$redirectName == home or link_issue or link_issue_dberr

   //Finally redirect
   return redirect("/notification");
    die();

}

public function index(Request $request){
        $action = $request->action;
        $tk = $request->tk;

         if ($action != "secure1" && $action != "secure2"){
            //Find this method above
          return $this->setVerifyLinkSession('home',$request);
         }

         $request->session()->put('action', $action);
         $request->session()->put('tk', $tk);
        
         return Inertia::render('auth/Verify');
       
  }

  public function verifyLink(Request $request){
        $redirectLink = "";
        $action = "";
        $tk = "";

     if ($request->session()->has('action')) {
        $action = $request->session()->pull('action','');
        
      }

      if ($request->session()->has('tk')) {
        $tk = $request->session()->get('tk');
      }
        
          //check if action matches what we are looking for.
     //Send error if it does not match
        if ($action != "secure1" && $action != "secure2"){
           //Find this method above
          return $this->setVerifyLinkSession('home',$request);
        }

        if ($tk == ""){
            //Find this method above
          return $this->setVerifyLinkSession('home',$request);
        }

        //Set redirect link

        if($action == "secure1"){
            $redirectLink = "/register";
        }

        if($action == "secure2"){
            $redirectLink = "/forgotten-password";
        }

       //DECODE AND VERIFY THE TOKEN
      $verifyRes = $this->decodeToken($tk);

       if($verifyRes["msg"] == "Good"){
            
           $email = $verifyRes["data"]->email;
             //Check to unsure is email
               if (!$this->checkIsEmail($email)) {
                 //Find this method above
               return $this->setVerifyLinkSession('home',$request);
              }
               //check if link has already been used in DB.
               $userOutCome = User::checkIfUserExist('email',$email);
               //check if the user outcome is error
               if($userOutCome["error"]){
                //Find this method above
                return $this->setVerifyLinkSession('link_issue',$request,$redirectLink);

                }//End if out come error

                if($userOutCome["user"] != ""){
                   //Check the value of token status
                   $userRes =  $userOutCome["user"];
                    if($userRes->token_status == "no"){
                       //All good
                       return redirect()->route('resetPass.index');
                    }else{
                     //Token already used 
                    //Find this method above
                     return $this->setVerifyLinkSession('link_issue',$request,$redirectLink);
                    }// end  if $userRes->token_status != "yes"
             
                }else{

                   //if user is empty a new registration(new user)
                   return redirect()->route('register.complete.index');
                  
                 }//End if useroutcome is not empty

        }else if($verifyRes["msg"] == "Invalid"){
           
         //Find this method above
        return $this->setVerifyLinkSession('link_issue',$request,$redirectLink);
         
      }else{
          
           //Find this method above
        return $this->setVerifyLinkSession('link_issue_dberr',$request,$redirectLink);
       
      }

    }// End verifyLink

}//end class
