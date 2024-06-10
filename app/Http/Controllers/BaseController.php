<?php

namespace App\Http\Controllers;

use App\Traits\HelperTrait;
use App\Traits\TokenTrait;
use App\Lib\Cloudinary;

class BaseController extends Controller
{

  use HelperTrait;
  use TokenTrait;
  //METHODS USED FROM HelperTrait
  //sendAlinkToUser

  public $linkExpireTime = 2400; //(40mins)

  public function cloudinaryInstance()
  {
    $cloudinary = new Cloudinary();
    return  $cloudinary;
  } //End cloudinaryInstance



  public function returnCloudinaryDefaultLink()
  {
    return "https://res.cloudinary.com/icblog254/image/upload/v1662665884/icblog/siteimgs/vqkopmclbqxlbtfk9b59.png";
  }

  public function returnResultPerPageNumber()
  {
    return 20;
  }

  public function checkId($id, $route_name)
  {
    if ($id == "" || !is_numeric($id)) {
      return redirect()
        ->route($route_name)
        ->withErrors(["fail" => $this->returnGenericSystemErrMsg()]);
    } //end if id is empty or is not a number

  }
}//End class
