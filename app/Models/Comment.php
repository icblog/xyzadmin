<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model{
    use HasFactory;

    protected $fillable = ['user_id','post_id','reply_total','body'];

public static function countComment($whereColumn="", $equalToValue=""){
        $outComeArray = array("error"=>false, "commentCount"=> 0);
      
      try {

          if($equalToValue ==""){
            $outComeArray["commentCount"] = DB::table('comments')->count();
            }else{
              $outComeArray["commentCount"] = DB::table('comments')->where($whereColumn, $equalToValue)->count();
          }
           return $outComeArray;
      
        } catch (\Exception $e) { 
          $outComeArray["error"] = true;
          return $outComeArray;
        }
       
}//End check comments post


public static function fetchPostComment($postId, $resultPerPage=4, $paginate=false){
  $outComeArray = array("error"=>false, "commentResult"=> []);

try {
        $query = DB::table('comments')
                ->select('comments.id','comments.reply_total','comments.body','comments.created_at','A.username as commented_by')
                ->join('users AS A', 'A.id', '=', 'comments.user_id')
                ->where('comments.post_id', $postId)
                ->orderBy('comments.id', 'desc');
                
                if($paginate){
                  $outComeArray["commentResult"] = $query->paginate($resultPerPage);
                }else{
                  $outComeArray["commentResult"] = $query->limit($resultPerPage)
                  ->get();
                }
    return $outComeArray;

  } catch (\Exception $e) {
    dd($e); 
    $outComeArray["error"] = true;
    return $outComeArray;
  }
 
}//End fetchPostComment


public static function selectPreviousUserComment($postId, $userId){
  $outComeArray = array("error"=>false, "commentResult"=> null);

try {
  $outComeArray["commentResult"] = DB::table('comments')
                ->select('comments.id','comments.body','comments.created_at')
                ->where('comments.post_id', $postId)
                ->where('comments.user_id', $userId)
                ->first();
      return $outComeArray;

  } catch (\Exception $e) {
    //dd($e); 
    $outComeArray["error"] = true;
    return $outComeArray;
  }
 
}//End selectPreviousUserComment




}//End class
