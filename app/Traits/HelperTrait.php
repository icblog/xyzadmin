<?php
namespace App\Traits;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;

trait HelperTrait{

public function replaceFirstOccuranceOfChar($search, $replace, $subject){

  $pos = strpos($subject, $search);
  if ($pos !== false) {
      return substr_replace($subject, $replace, $pos, strlen($search));
  }
  return $subject;
}
  
public function returnGenericSystemErrMsg(){
	return "Sorry system error, your request can not be processed please contact a team leader or a manager thank you";
}//End returnGenericSystemErrMsg

public function returnLinkErrMsg(){
	return "Sorry the link has expired or Invalid,  you will be redirected to create a new one thank you.";
}//End returnGenericSystemErrMsg

public function sendAlinkToUser($token,$email,$subject,$emailTemplate){
  $outComeArray = array("error"=>"", "outcome"=>"");
 
  $verifyLink = env('APP_URL')."/verify/".$token;
  
  $dataArray = array(
      "name"=>"",
      "link"=>$verifyLink
  );
   //convert data array into data object for blade view
  $dataObj = (object)$dataArray;
  try {

      Mail::to($email)->send(new AppMail($subject,$emailTemplate,$dataObj));
      $outComeArray["outcome"] = true; 
      return $outComeArray;

  } catch (\Exception $e) { 
    $outComeArray["error"] = true; 
    return $outComeArray;
  }

}// End sendAlinkToUser

public function sendRegEmail($fname,$username,$email,$password,$subject,$emailTemplate){
  $outComeArray = array("error"=>"", "outcome"=>"");
 
   $dataArray = array(
      "name"=>$fname,
      "username"=>$username,
      "email"=>$email,
      "password"=>$password,
     
  );
   //convert data array into data object for blade view
  $dataObj = (object)$dataArray;
  try {

      Mail::to($email)->send(new AppMail($subject,$emailTemplate,$dataObj));
      $outComeArray["outcome"] = true; 
      return $outComeArray;

  } catch (\Exception $e) { 
    $outComeArray["error"] = true; 
    return $outComeArray;
  }

}// End sendRegEmail

public function sendAbsenceEmail(
  $msg_type,
  $fname,
  $called_date,
  $called_time,
  $date_for,
  $shift_start_time,
  $shift_end_time,
  $ref_number,
  $reason,
  $work_related,
  $comment,
  $co_worker_name,
  $subject,
  $emailTemplate,
  $email_address
  ){
  $outComeArray = array("error"=>"", "outcome"=>"");
 
  $dataArray = array(
    'msg_type' => $msg_type,
    'name' => $fname, 
    'date'=> $called_date,
    'time'=> $called_time,
    'date_for'=> $date_for,
    'shift_start_time'=> $shift_start_time,
    'shift_end_time'=> $shift_end_time,
    'reference_number'=> $ref_number,
    'absence_reason'=> $reason,
    'work_related'=> $work_related,
    'comment'=> $comment,
    'co_worker_name'=> $co_worker_name,
 );
   //convert data array into data object for blade view
  $dataObj = (object)$dataArray;
  try {

      Mail::to($email_address)->send(new AppMail($subject,$emailTemplate,$dataObj));
      $outComeArray["outcome"] = true; 
      return $outComeArray;

  } catch (\Exception $e) { 
    $outComeArray["error"] = true; 
    return $outComeArray;
  }

}// End sendAsenceEmail



public function checkIsEmail($email){
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     return false;
  }else{
    return true;
  }
}

public function returnReplacedStr($str,$findWhat,$replaceWith){
	$str = trim($str);
  $str1 = strtolower(str_replace($findWhat,$replaceWith,$str));	
  return $str1;	
}

public function cleanData($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}// end CleanData

public function randomNumber($length = 6){
      $chars = "0123456789";
      $string = substr( str_shuffle( $chars ), 0, $length );
      return $string;
  } 
  
  public function randomString( $length = 6 ){
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $string = substr( str_shuffle( $chars ), 0, $length );
      return $string;
  }
  
  public function encodeUserData($userData){
    $salt = env('APP_KEY', '');
    $encryptedUserData = base64_encode($userData . $salt);
    return $encryptedUserData;
   
 }// function encodeUserData
 
 public function decodeUserData($encryptedUserData){
   $salt = env('APP_KEY', '');
   $decryptedUserDataRaw = base64_decode($encryptedUserData);
   $decryptedUserData = preg_replace(sprintf('/%s/', $salt), '', $decryptedUserDataRaw);
   return  $decryptedUserData;
   
 }// function decodeUsertData

   public function returnTimeStamp(){
    return date("Y-m-d H:i:s");
   }

   public function checkExactMatchOfString($str,$needle){
    if (preg_match("~\b$needle\b~", $str)) {
      return true;
     }else{
      return false;
     }
   }

   public function datetimeToText($datetime=""){
	  $unixdatetime = strtotime($datetime); 
	  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
    }

    public function returnDate($datetime=""){
      
      if($datetime == ''){
        return date("D, d M Y",strtotime($this->returnTimeStamp()));
      }else{
        return date("D, d M Y",strtotime($datetime));
      }
      
    }

    

    public function validatePhone($phoneNumber){
      $res = preg_match('/^(((\+44)? ?(\(0\))? ?)|(0))( ?[0-9]{3,4}){3}$/',$phoneNumber);
     // dd($res);
      return $res;
    }
 }// END CLASS
