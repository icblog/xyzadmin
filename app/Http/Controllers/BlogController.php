<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Reply;
use App\Lib\BadWords;
use App\Models\User;


class BlogController extends BaseController{

    private $resultPerPage = 12;

    public function redirectToBlogHome($action,$linkSlug){
      
        return redblog.indexirect()
        ->route('', [$action,$linkSlug])
        ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()]);
    }//End method redirectToBlogHome

    public function index(Request $request){
        $dataToView = "";
        $pageIntro =  "Latest post";
        $latestPostResult =  array();
        $popularPostResult = array();
        $categoriesResult = array();
        $mainResult = array();
        $paginate = true;
        $defaultImgLink = $this->returnCloudinaryDefaultLink();
   
     try{

         //Fetch latest 6 post and pass to home view
          $latestPostResult = Post::fetchLatestPost($this->resultPerPage, $paginate);
     
          $popularPostResult = Post::fetchPopularPost($this->resultPerPage, $paginate);
         //Fetch all categories
          $categoriesResult = Category::fetchCategoriesWithCount();
     
   if($request->action == "post" && $request->slug  == "latest"){
        $mainResult  = $latestPostResult['postResult'];
       
    }elseif($request->action == "post" && $request->slug  == "popular"){
        $mainResult  = $popularPostResult['postResult'];
        $pageIntro = "Popular post";
       
        
    }elseif($request->action == "category"){
        $catgoryPostResult = Post::fetchPostWithCategorySlug($this->resultPerPage,$request->slug);
        $mainResult = $catgoryPostResult['postResult'];
        $pageIntro = "Category: ".Str::replace('-', ' ', $request->slug);

    }else{
        return redirect()->route('home.index'); 
    }

     $dataToView = array(
        "pageIntro"=> $pageIntro,
        "latestPostResult"=> $latestPostResult['postResult'],
        "popularPostResult"=> $popularPostResult['postResult'],
        "categoriesResult"=> $categoriesResult["result"],
        "mainResult"=> $mainResult,
        "urlSlug"=> $request->slug,
        "urlAction"=> $request->action,
        "defaultImgLink"=>$defaultImgLink

     );

     return Inertia::render('blog/BlogHome',$dataToView);

     }catch(\Exception $e){
       
        $this->redirectToBlogHome($request->action,$request->slug);
    }

  }//End method index

   
  public function single(Request $request){
    
     if($request->postslug ==""){
        return redirect()->route('home.index');
      }

    $isAdmin = false;
    $whereColumn = "slug";
    $equalToValue = $request->postslug;
    
     $dataToView = array(
      "previousUserCommentResult"=>false,
        "singlePostResult"=> null,
        "latestPostResult"=> [],
        "popularPostResult"=> [],
        "categoriesResult"=> [],
        "postCommentResult"=> [],
        "nextPostResult" => null,
        "previousPostResult" => null,
        "defaultImgLink"=> $this->returnCloudinaryDefaultLink(),
        "urlSlug"=> $request->postslug,
     );

    

     try{
      
        //Fetch latest post
      $latestPostResult = Post::fetchLatestPost();
      $popularPostResult = Post::fetchPopularPost();
      //Fetch all categories
      $categoriesResult = Category::fetchCategoriesWithCount();

    $singlePostResult = Post::fetchSinglePost($isAdmin, $whereColumn, $equalToValue);
       //dd($singlePostResult["postResult"]);
      //If no error and we have post result update the post views column in db 
       if(!$singlePostResult["error"] && !is_null($singlePostResult["postResult"])){
          Post::where('slug', $equalToValue)->update(['views' => $singlePostResult["postResult"]->views+1]);   
         
          $singlePostResult["postResult"]->catSlugs =   explode(",",$singlePostResult["postResult"]->catSlugs);
          $singlePostResult["postResult"]->catNames = explode(",",$singlePostResult["postResult"]->catNames);
          $dataToView["singlePostResult"] = $singlePostResult["postResult"];
          //Fetch next and previous post
          $nextPostResult = Post::fetchNextOrPreviousPost($singlePostResult["postResult"]->id,"next");
          $previousPostResult = Post::fetchNextOrPreviousPost($singlePostResult["postResult"]->id,"previous");
          
            if(!$nextPostResult["error"]){
              $dataToView["nextPostResult"] = $nextPostResult["postResult"];
            }

             if(!$previousPostResult["error"]){
                $dataToView["previousPostResult"] = $previousPostResult["postResult"];
             }

             //Fetch previous comment by the loggedin user
             if(Auth::check()){
               $previousCommentRes = Comment::selectPreviousUserComment($singlePostResult["postResult"]->id, Auth::user()->id);
            // dd($previousCommentRes);
              if(!$previousCommentRes["error"] && $previousCommentRes['commentResult'] != null){
                $dataToView["previousUserCommentResult"] = true;
              }
            
            }
             
            //Fetch All post comments
             $postCommentRes = Comment:: fetchPostComment($singlePostResult["postResult"]->id, 1, true);
             if(!$postCommentRes["error"]){
               $dataToView["postCommentResult"] = $postCommentRes['commentResult'];
             }
          }//end  !$singlePostResult


        if(!$latestPostResult["error"]){
            $dataToView["latestPostResult"] = $latestPostResult['postResult'];
        }

        if(!$popularPostResult["error"]){
            $dataToView["popularPost"] = $popularPostResult['postResult'];
        }

        if(!($categoriesResult["error"])){
            $dataToView["categoriesResult"] = $categoriesResult["result"];
        }
        
        return Inertia::render('blog/BlogSingle',$dataToView);

     }catch(\Exception $e){
     // dd($e);
        return redirect()
        ->route('blog.single',[$request->postslug])
        ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()]);
    }
      
  
  }//End method getSinglePost

  public function searchPost(Request $request){

    if(!is_string($request->searchedword)){
      return response()->json([
                  'error' => $this->returnGenericSystemErrMsg()
       ]);
    }//End if error

    $categoryRes = array(); 
     $postRes = array();
     $defaultImgLink = "";

    $postSearchResults =  Post::searchPost($request->searchedword);
    $categorySearchResults = Category::searchCategory($request->searchedword);

    if($postSearchResults["error"] || $categorySearchResults["error"]){
        
        return response()->json([
                    'error' => $this->returnGenericSystemErrMsg()
         ]);
    }//End if error
     // dd($postSearchResults["searchResult"]);

     if(!empty($postSearchResults["searchResult"])){
       $postRes = $postSearchResults["searchResult"];
       $defaultImgLink = $this->returnCloudinaryDefaultLink();
     } 

     if(!empty($categorySearchResults["searchResult"])){
      $categoryRes = $categorySearchResults["searchResult"];
    } 

     
    return response()->json([
        'error' => "",
        'postResData' => $postRes,
        'categoryResData' => $categoryRes,
        'defaultImgLink' => $defaultImgLink
     ]);

  }//End method search


  public function fetchCommentReplies(Request $request){

    if ($request->commentId == "" || !is_numeric($request->commentId)) {
         return response()->json([
          'error' => [$this->returnGenericSystemErrMsg()],
        ]);
        die();
      }// end if request is empty
   
      //If no errors delete category
        try {
          $commentReplyRes = Reply:: fetchCommentReply($request->commentId, 10, false);
           if($commentReplyRes["error"]){
            return response()->json([
              'error' => [$this->returnGenericSystemErrMsg()],
            ]);
           }
          
          return response()->json([
          "error" => "",
          "repliesData"=> $commentReplyRes["commentReplyResult"]
        ]);
      } catch (\Exception $e) {
             //dd($e);
       return response()->json([
       'error' => [$this->returnGenericSystemErrMsg()],
   
      ]);
   
   }
   
   }//End fetchCommentReplies

   public function saveComment(Request $request){
     
   if($request->saveOrUpdateOrDelete != "delete"){
      //Check if myhouse the hidden recaptcha input is filled in,
        //if that is the case redirect to home page.
        if($request->myhouse != ''){
          return redirect()->route('home.index');
          die();
      }
    
    if(!is_string($request->comment)){
      return response()->json([
                  'outcome' => [$this->returnGenericSystemErrMsg()]
       ]);
    }//End if !string

    //Remove bad words
    $badWords =  new  BadWords();
    $commentBody = $badWords->replaceBadWords($request->comment);
   
  }

    try{

    if($request->saveOrUpdateOrDelete == "save"){
      $comment = Comment::create([
        'user_id' => Auth::user()->id,
        'post_id' => $request->postId,
        'body' => $commentBody
       ]);

       return response()->json([
        'outcome' =>true,
        "res" => [
        'id'=> $comment->id,
        ]
        
     ]);
     
    //  dd();

    }else if($request->saveOrUpdateOrDelete == "update"){

      Comment::where('id', $request->commentId)->update(['body'=>$commentBody]);

    }else if($request->saveOrUpdateOrDelete == "delete"){
      Comment::where('id', $request->commentId)->delete();
      Reply::where('comment_id', $request->commentId)->delete();
    }else{
      return response()->json([
        'outcome' => [$this->returnGenericSystemErrMsg()],
       
      ]);
    }
       return response()->json([
               "outcome" => true,
            ]);

} catch (\Exception $e) {
         //dd($e);
      return response()->json([
        'outcome' => [$this->returnGenericSystemErrMsg()],
       
      ]);
   }

}// End saveComment

public function saveCommentReply(Request $request){
  if(!is_string($request->replyMsg)){
    return response()->json([
                'outcome' => [$this->returnGenericSystemErrMsg()]
     ]);
  }//End if !string


   //Remove bad words
   $badWords =  new  BadWords();
   $replyBody = $badWords->replaceBadWords($request->replyMsg);

  try{

    $reply = new Reply;
    $reply->user_id = Auth::user()->id;
    $reply->comment_id = $request->commentId;
    $reply->body = $replyBody;
  
    if($request->action == "replies-reply"){
      $repliedToId = User::select('id')->where('username', $request->replyToUsername)->first();
      if(!is_null($repliedToId)){
        $reply->reply_to_id = $repliedToId->id;
      }
       $reply->parent_id = $request->replyId;
    }
   
    $reply->save();

   Comment::where('id', $request->commentId)->update(['reply_total'=>$request->totalCommentReplies + 1]);
       return response()->json([
             "outcome" => true,
          ]);

     } catch (\Exception $e) {
        // dd($e);
    return response()->json([
      'outcome' => [$this->returnGenericSystemErrMsg()],
     
    ]);
 }

}// End saveCommentReply


public function updateOrDeleteCommentReply(Request $request){

  try{

     if($request->updateOrDelete == "update"){
      if(!is_string($request->replyMsg)){
        return response()->json([
                    'outcome' =>[$this->returnGenericSystemErrMsg()]
         ]);
      }//End if !string
      //Remove bad words
      $badWords =  new  BadWords();
      $replyBody = $badWords->replaceBadWords($request->replyMsg);
      Reply::where('id', $request->replyId)->update(['body'=>$replyBody]);
     }else if($request->updateOrDelete == "delete"){
      Reply::where('id', $request->replyId)->delete();
      Comment::where('id', $request->commentId)->update(['reply_total'=>$request->totalCommentReplies - 1]);
     }else{
      
       return response()->json([
       
      'outcome' => [$this->returnGenericSystemErrMsg()],
       
      ]);
     }
       return response()->json([
             "outcome" => true,
      ]);

     } catch (\Exception $e) {
        dd($e);
    return response()->json([
    
      'outcome' => [$this->returnGenericSystemErrMsg()],
    ]);
 }

}// End updateOrDeleteCommentReply
   
 
public function checkReplyAlreadyExit(Request $request){

  try{
    $outcome = false;
   $replyRes = Reply::select('id')
   ->where('comment_id', $request->commentId)
   ->where('user_id', Auth::user()->id)
   ->where('parent_id', 0)
   ->first();
      // dd($replyRes->id);
       if(!is_null($replyRes)){
        //result code goes here
           $outcome = true;
         }
   return response()->json([
             "error"=>"",
             "outcome" => $outcome,
          ]);

     } catch (\Exception $e) {
         dd($e);
    return response()->json([
      'error' => [$this->returnGenericSystemErrMsg()],
     
    ]);
 }

}// End saveCommentReply


}
