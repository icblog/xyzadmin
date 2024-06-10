<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends BaseController{

  public function index(){
    
      return Inertia::render('auth/Login');
        
   }//End index

   public function handleLoginForm(Request $request){
        //Check if myhouse the hidden recaptcha input is filled in,
        //if that is the case redirect to home page.
        
        if($request->myhouse != ''){
            return redirect()->route('home.index');
            die();
        }

        //Custom attribute names
        $attributeNames = array(
          'email_username' => 'Username or email'
        );

        $validator = Validator::make($request->all(), [
           'email_username' => 'required|string',
           'password'=>'required|string',
       ]);
       
        //Use custom attributes names for error reporting
       $validator->setAttributeNames($attributeNames);
       
        if ($validator->fails()) {
            return redirect()
                    ->route('login.index')
                    ->withErrors($validator)
                    ->withInput();
          die();
        }//end if validation
       
        //Attempt to Log in user if validation pass
           try {
            //Check whether is email or username
            $fieldType = filter_var($request->email_username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $credentials = array(
                $fieldType => $request->email_username,
                'password' => $request->password
            );
           
            $user = Auth::attempt($credentials);

           // dd(Auth::user()->using_system_pass);

               //If that failed too, send an error
              if(!$user){
                return redirect()
                    ->route('login.index')
                    ->withErrors(["fail"=>"The provided credentials do not match our records, please try again."])
                    ->withInput();
               }

              
                // set redirect link 
               $defaultUrl = route("home.index");

                //if user is using system generated pass, set session and redirect them to reset pass
               

                 if(Auth::user()->using_system_pass == 'yes'){
                 
                  $defaultUrl = route("resetPass.index");
                  
                  $request->session()->put('system_pass', 'yes');
                 
                }else{
                  //If all good log the user in and feedback

                  User::updateLastLoginDate();
                  $request->session()->put('system_pass', 'no');
                  $request->session()->regenerate();
              
                }// end if using system password

                return redirect($defaultUrl);
            
        } catch (\Exception $e) {
              return redirect()
                    ->route('login.index')
                    ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
                    ->withInput();
        }
       
    }//End handleLoginForm

    
}
