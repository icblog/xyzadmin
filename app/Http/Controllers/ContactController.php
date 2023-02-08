<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Inertia\Inertia;


class ContactController extends BaseController{

   

   public function index(){
       
    return Inertia::render('Contact');
        
    }

public function handleContact(Request $request){
     //Check if myhouse the hidden recaptcha input is filled in,
        //if that is the case redirect to home page.
        
        if($request->myhouse != ''){
            return redirect()->route('home.index');
            die();
        }

    $validator = Validator::make($request->all(), [
       'name'=>'required|string',
       'email' => 'required|string|email',
       'message'=>'required|string',
   ]);

   if ($validator->fails()) {
    return redirect()
            ->route('contact.index')
            ->withErrors($validator)
            ->withInput();
  die();
}//end if validation

  $dataArray = array(
      "name"=>"Admin",
      "c_name"=>$request->name,
      "c_email"=>$request->email,
      "c_message"=>$request->message
  );
   //convert data array into data object for blade view
  $dataObj = (object)$dataArray;
  $subject = "Message from icBlog";
  $emailTemplate = "mail.new-contact";

   
  try {

      Mail::to(env('APP_ADMIN_EMAIL'))->send(new AppMail($subject,$emailTemplate,$dataObj));

       //set session data for notification page
       $msg = "Message sent successfully, I will get back to you as soon as I'm able to thank you";
       $request->session()->put('redirectLink', "/");
       $request->session()->put('type', "success");
       $request->session()->put('msg', $msg);
       $request->session()->put('redirectTime', 8000);
       return redirect("/notification");

  } catch (\Exception $e) { 
    return redirect()
    ->route('contact.index')
    ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
    ->withInput();
}


 }//End method index

    
}
