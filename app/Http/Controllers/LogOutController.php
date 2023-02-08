<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LogOutController extends BaseController{

    public function index(){
        return Inertia::render('auth/Logout');
    }//End index

    public function handleLogout(Request $request){
      $redirectLink = "/home";
      $type = "success";
      $msg = "You have log out successfully";
      $redirectTime = 4000;
        try {

            Auth::logout();
       
          $request->session()->invalidate();
       
          $request->session()->regenerateToken();

          //set session data for notification page
            $this->setNotificationSessionData(
              $redirectLink,
              $type,
              $msg,
              $redirectTime,
              $request
            );
        
          return redirect("/notification");
       
     } catch (\Exception $e) {

        $type = "error";
        $msg = "Sorry system error, please clear your browser history or close your browser and your session should be destroyed thank you";
        $this->setNotificationSessionData(
          $redirectLink,
          $type,
          $msg,
          10000,
          $request
        );
        
       return redirect("/notification");
       
      }
        
    }//End logout

    
}

