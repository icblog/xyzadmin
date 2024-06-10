<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\BaseController;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LogOutController extends BaseController{

    public function index(){
        return Inertia::render('auth/Logout');
    }//End index

    public function handleLogout(Request $request){
     
        try {

            Auth::logout();
       
          $request->session()->invalidate();
       
          $request->session()->regenerateToken();

          $request->session()->put('respondsMsg', "code200");
          return redirect()
           ->route('logout.index');
          die();
       
     } catch (\Exception $e) {

      $request->session()->put('respondsMsg', "code000");
      return redirect()
       ->route('logout.index');
      die();
       
      }
        
    }//End logout

    
}

