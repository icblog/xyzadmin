<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;



class HomeController extends BaseController{
 

   public function index(Request $request){
    return Inertia::render('Home');
       
  }

    
}
