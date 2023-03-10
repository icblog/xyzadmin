<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reply extends Model{
    use HasFactory;



public static function fetchCommentReply($commentId, $resultPerPage=4, $paginate=false){
  $outComeArray = array("error"=>false, "commentReplyResult"=> []);

try {
        $query = DB::table('replies')
                ->select('replies.id','replies.parent_id','replies.comment_id','replies.body','replies.created_at','A.username as replied_by','A.id as replied_by_id','B.username as replied_to')
                ->join('users AS A', 'A.id', '=', 'replies.user_id')
                ->leftjoin('users AS B', 'B.id', '=', 'replies.reply_to_id')
                ->where('replies.comment_id', $commentId)
                ->orderBy('replies.id', 'asc');
                
                if($paginate){
                  $outComeArray["commentReplyResult"] = $query->paginate($resultPerPage);
                }else{
                  $outComeArray["commentReplyResult"] = $query->limit($resultPerPage)
                  ->get();
                }
    return $outComeArray;

  } catch (\Exception $e) {
    dd($e); 
    $outComeArray["error"] = true;
    return $outComeArray;
  }
 
}//End fetchPostComment


}//End class
