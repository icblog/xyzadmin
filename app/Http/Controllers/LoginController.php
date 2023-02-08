<?php

namespace App\Http\Controllers;

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

               //If that failed too, send an error
              if(!$user){
                return redirect()
                    ->route('login.index')
                    ->withErrors(["fail"=>"The provided credentials do not match our records, please try again."])
                    ->withInput();
               
              }

              //If all good log the user in and feedback ajax

               User::updateLastLoginDate();
               $request->session()->regenerate();
                
               $defaultUrl = route("blog.index",["post","latest"],false);//route name
                 if(Auth::user()->role == 1){
                  $defaultUrl = route("admin.dashboard",[],false);
                 }
                 //Intended url is stored in session by admin middleware located in the middleware folder 
                 $defaultUrl = $this->replaceFirstOccuranceOfChar("/","",$defaultUrl);
                 $intendedUrl =  $request->session()->pull('intendedUrl', $defaultUrl);
                 //dd($intendedUrl);
                 return redirect($defaultUrl);
            
        } catch (\Exception $e) {
              return redirect()
                    ->route('login.index')
                    ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
                    ->withInput();
        }
       
    }//End handleLoginForm

    
}
