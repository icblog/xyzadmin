<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


class AdminDashboardController extends BaseController{

   public function index(){

    return Inertia::render('admin/Dashboard');
       
  }

    
}
