<?php
namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ForgottenPasswordController extends BaseController{
//METHODS USED FROM HELPER TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
//returnGenericSystemErrMsg

//METHODS USED FROM TOKEN TRAIT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
//genarateToken

  public function index(){
    return Inertia::render('auth/ForgottenPassword');
        
    }//End index

    public function handleForgottenPasswordForm(Request $request){
            //Check if mmyhouse the hidden recaptcha input is filled in,
        //if that is the case redirect to home page.
        
        if($request->myhouse != ''){
          return redirect()->route('home.index');
          die();
      }

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email'
        ]);

        if ($validator->fails()) {
          return redirect()
                  ->route('forgottenpassword.index')
                  ->withErrors($validator)
                  ->withInput();
        die();
      }//end if validation

          //Check if user exist if so send the a link to reset their password.
      
            $userOutCome = User::checkIfUserExist('email',$request->email);
            //check if the user outcome is error
            if($userOutCome["error"]){

              return redirect()
                    ->route('forgottenpassword.index')
                    ->withErrors(["fail"=>$this->returnGenericSystemErrMsg()])
                    ->withInput();
           
                die();
            }else if(!is_null($userOutCome["user"])){

              

             //Generate token
        $tokenData = array('email' => $request->email);
        $token = $this->genarateToken($this->linkExpireTime,$tokenData);//expire time in seconds(10mins)

        //if user exist, send a password reset link.
      //if not send verify link to user email.
            
      $sendLinkOutCome = $this->sendPasswordWordResetLink($token, $request->email);
            
      if($sendLinkOutCome["error"]){
        return redirect()
                    ->route('forgottenpassword.index')
                    ->withErrors(["fail"=>$this->returnGenericSystemErrMsg()])
                    ->withInput();
            die();
          }//End if out come error
              
              
  }//End if user out come error

    
       //No user return the success reponds regardless
       //set session data for notification page
        $msg = "Please check your email and follow the instruction to continue if you have account thank you.";
       $request->session()->put('redirectLink', "/");
       $request->session()->put('type', "info");
       $request->session()->put('msg', $msg);
       $request->session()->put('redirectTime', 8000);
       return redirect("/notification");

  }//End handleForgottenPasswordForm

    
}