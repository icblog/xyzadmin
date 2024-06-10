<?php
namespace App\Http\Controllers\EmailTest;
use App\Http\Controllers\BaseController;


class EmailTestController extends BaseController{


    public function index(){
      $data = array(
         'msg_type' => 'absence',
         //'msg_type' => 'responsible',
         'name' => 'James', 
       
         'date'=>'Thu Oct 05 2023',
         'time'=>'09:34',
         'reference_number'=>'VW-452',
         'absence_reason'=>'Back pain',
         'comment'=>'Ongoing',
         'co_worker_name'=>'Apple Banana',
      );
      $dataObj = (object)$data;
    
      return view('mail.absence-coworker-responsible')->with(['dataObj'=>$dataObj]);
   }

}