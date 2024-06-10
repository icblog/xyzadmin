<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\BaseController;
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

          //update token and what was change field in db
          User::where('email',$request->email)->update(['token_status' => 'no','what_was_change' => 'Token status']);

         //Generate token
        $tokenData = array('email' => $request->email);
        $token = $this->genarateToken($this->linkExpireTime,$tokenData);//expire time in seconds(10mins)

        //Send the link email.
         $subject ="About your account";
         $emailTemplate = "mail.password-reset-template";
        $sendLinkOutCome = $this->sendAlinkToUser($token, $request->email,$subject,$emailTemplate);
       // if mail failed send generic error msg     
      if($sendLinkOutCome["error"]){
        return redirect()
                    ->route('forgottenpassword.index')
                    ->withErrors(["fail"=>$this->returnGenericSystemErrMsg()])
                    ->withInput();
            die();
       }//End if out come error
  }//End if user out come error

    
       //No user return the success reponds regardless
        $request->session()->put('respondsMsg', "code200");
       return redirect()
        ->route('forgottenpassword.index');
       die();
}//End handleForgottenPasswordForm

    
}