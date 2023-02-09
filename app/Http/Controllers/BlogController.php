<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Category;

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
        "singlePostResult"=> null,
        "latestPostResult"=> [],
        "popularPostResult"=> [],
        "categoriesResult"=> [],
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

      //dd($request->searchedword);
     $postRes = array();
     $defaultImgLink = "";

    $searchResults =  Post::searchPost($request->searchedword);

    if($searchResults["error"]){
        return response()->json([
                    'error' => $this->returnGenericSystemErrMsg()
         ]);
    }//End if error
     // dd($searchResults["searchResult"]);

     if(!empty($searchResults["searchResult"])){
       $postRes = $searchResults["searchResult"];
       $defaultImgLink = $this->returnCloudinaryDefaultLink();
     } 
    return response()->json([
        'error' => "",
        'postData' => $postRes,
        'defaultImgLink' => $defaultImgLink
     ]);

  }//End method search
    
}
