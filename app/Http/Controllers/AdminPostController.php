<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostsXCategory;
use App\Models\Postimage;
use Illuminate\Support\Str;

class AdminPostController extends BaseController{

  private $resultPerPage = 12;

   public function createPostIndex(){
    $dataToView = array(
      "categoriesResult"=> [],
    );

    try{
        $dataToView["categoriesResult"] = Category::fetchCategories();
        return Inertia::render('admin/CreatePost', $dataToView);

    }catch(\Exception $e){
      return redirect()
      ->route('admin.createPostIndex')
      ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()]);
  }

}// End createPostIndex


public function createPostSave(Request $request){

  //dd($request);

 //Custom validation attribute names
  $attributeNames = array(
  'selectedCategories' => 'category',
  'saveorpublish' => 'save or publish',
  );
$validator = Validator::make($request->all(), [
  'title' => 'required|string',
  'selectedCategories' => 'required|array',
  'postbody' => 'required|string',
  'saveorpublish' => 'required|string',
]);
 
$validator->setAttributeNames($attributeNames);
  if ($validator->fails()) {
    return redirect()
            ->route('admin.createPostIndex')
            ->withErrors($validator)
            ->withInput();
  die();
  }//end if validation
//Generate slug from the title
$slug  = $this->returnReplacedStr($request->title," ","-");

    // Check if post exist
$postOutCome = Post::checkIfPostExist($slug);

if($postOutCome["error"]){
  return redirect()
  ->route('admin.createPostIndex')
  ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
  ->withInput();
}//End if out come error

if($postOutCome["success"]){
  return redirect()
  ->route('admin.createPostIndex')
  ->withErrors(["fail"=> "Sorry post title (".$request->title.") already exist, please choose another name."])
  ->withInput();
die();
}//End if out come success

try {
//Initialize post Model
$post = new Post();
  
if($request->totalFiles > 0){
  $post->has_images = "yes";
  $post->cloudinary_folder_name = $slug;

}//End if total files is greater than zero

//Save data in DB
$post->created_by = Auth::user()->id;
$post->title = $request->title;
$post->slug = $slug;
$post->body = $request->postbody;
$post->status = $request->saveorpublish;
$post->save();

if($request->totalFiles > 0){
  //store Image In Db And Cloudinary
  //Find this method at the bottom of this class
   $this->storeImageInDbAndCloudinary($request,$slug,$post->id,$request->totalFiles);
}//End if total files is greater than zero

    //Store post and catgory id in join table
    //Find this method at the bottom of this class
 $this->updatePostAndCategoryJoinTable($request,$post->id);

       //set session data for notification page
       $msg = "Post created successfully";
       $request->session()->put('redirectLink', route('admin.createPostIndex'));
       $request->session()->put('type', "success");
       $request->session()->put('msg', $msg);
       $request->session()->put('redirectTime', 1500);
       return redirect("/notification");
} catch (\Exception $e) {
   //dd($e);
return redirect()
->route('admin.createPostIndex')
->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
->withInput();
}

}//END create post

public function getAllPost(Request $request){
  $dataToView = "";
  $pageIntro =  "Admin all post";
  $mainResult = array();
  $paginate = true;
  $defaultImgLink = $this->returnCloudinaryDefaultLink();

try{
   $mainResult = Post::fetchPost(true,1,true,"","");
   
   //dd($mainResult['postResult']);
   
   $dataToView = array(
    "pageIntro"=> $pageIntro,
    "mainResult"=> $mainResult['postResult'],
    "defaultImgLink"=>$defaultImgLink

);

return Inertia::render('admin/AllPost',$dataToView);

}catch(\Exception $e){
   //dd($e);
   return redirect()
   ->route('admin.getAllPost')
   ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()]);
}

}//End method index



public function delete(Request $request){
  //Check post id is not empty, find checkPostId method below this page.
   $this->checkPostId($request->postId);

// Check if post exist
 $postOutCome = Post::checkIfPostExist($request->postId,"id");
 if($postOutCome["error"]){
  return response()->json([
      'outcome' => $this->returnGenericSystemErrMsg()
  ]);
   die();
}//End if out come error

if($postOutCome["success"]){
try {

//delete post
Post::where('id',$request->postId)->delete();
//delete post ids from post and category join table
PostsXCategory::where('post_id', $request->postId)->delete(); 

//delete cloudinary post images and folder from cloudinary if post has images
if($request->postHasImages == "yes"){
  //select all images where post id is the post to be deleted
  $postImages = Postimage::where('post_id', $request->postId)->get();
   //Loop and delete all images related to the post from cloudinary
  
  foreach($postImages as $postImage){
    $this->cloudinaryInstance()::destroy($postImage->public_id);
    }
  //Delete all images related to the post from DB
  Postimage::where('post_id', $request->postId)->delete(); 
  //Delete folder from Cloudinary
  $this->cloudinaryInstance()::deleteFolder("/icblog/postimgs/".$request->cloudinaryFolderName);
}//End if request has post images


return response()->json([
   "outcome" => true,
]);
} catch (\Exception $e) {

return response()->json([
'outcome' => $this->returnGenericSystemErrMsg(),

]);
}

}//End if out come success

}//End method delete Post


public function updatePostIndex(Request $request){

  //Check post id is not empty, find checkPostId method below this page.
  $this->checkPostId($request->postId);


  $dataToView = array(
    "singlePostResult"=> null,
    "categoriesResult"=> [],
  );

    try {
      $categoriesResult = Category::fetchCategories();
     
      $singlePostResult = Post::fetchSinglePost(true,"id", $request->postId);
   
         if(!$singlePostResult["error"] && !is_null($singlePostResult["postResult"])){
           $singlePostResult["postResult"]->catIds =   explode(",",$singlePostResult["postResult"]->catIds);
           $singlePostResult["postResult"]->catNames = explode(",",$singlePostResult["postResult"]->catNames);
           $dataToView["singlePostResult"] = $singlePostResult["postResult"];
         }//end  !$singlePostResult

         if(!empty($categoriesResult)){
          $dataToView["categoriesResult"] = $categoriesResult;
        }

         return Inertia::render('admin/UpdatePost',$dataToView);
      
         } catch (\Exception $e) {
      
        return redirect()
        ->route('admin.dashboard')
        ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()]);
   }
    
}//End updatePostIndex

public function updatePostSave(Request $request){
  //Check post id is not empty, find checkPostId method below this page.
  $this->checkPostId($request->postId);

//Set up custom attributes
$attributeNames = array(
  'selectedCategories' => 'category',
  'saveorpublish' => 'save or publish',
  );
 //Set up validation
  $validator = Validator::make($request->all(), [
    'title' => 'required|string',
    'selectedCategories' => 'required|array',
    'postbody' => 'required|string',
    'saveorpublish' => 'required|string',
  ]);

  $validator->setAttributeNames($attributeNames);
  //Redirect if validation fail with fail msg and inputs
    if ($validator->fails()) {
      return redirect()
      ->route('admin.updatePostIndex',[$request->postId])
      ->withErrors($validator)
      ->withInput();
      die();
   }//end if validation

     //Set array data for the update
    $postFieldToUpdate = array(
      "body"=>$request->postbody,
      "updated_by" => Auth::user()->id,
      "status" => $request->saveorpublish,
    );
     //Set title slug
    $oldSlug  = $this->returnReplacedStr($request->previousTitle," ","-");
    $newSlug = $this->returnReplacedStr($request->title," ","-");

    try {
      //If post has images previously,  check to see if any is getting deleted and if so
     // update DB AND CLOUDINARY records
      if($request->posthasImages == "yes"){
       
         if($request->existingPostImagesToBeDeletedLen > 0){
          //Loop and delete images from cloudinary and db
            foreach($request->existingPostImagesToBeDeleted as $postImageObj){
           $this->cloudinaryInstance()::destroy($postImageObj['imgPublicId']);
          //Delete images from DB 
           Postimage::where('public_id', $postImageObj['imgPublicId'])->delete(); 
        }
         }//end $request->existingPostImagesLen 
      }//end if post has images

     //If there are a new images to be upload, add to post array field above to be updated 
    if($request->totalNewFiles > 0){
        $postFieldToUpdate["has_images"] = "yes";
         $postFieldToUpdate["cloudinary_folder_name"] = $oldSlug;
         //store Image In Db And Cloudinary
         //Find this method at the bottom of this class
         $this->storeImageInDbAndCloudinary($request,$oldSlug,$request->postId,$request->totalNewFiles);
    }//End if total files is greater than zero
  
    //Set has_images field to no, if totalNewFiles & existingPostImagesTotal are both 0
if($request->totalNewFiles == 0 && $request->existingPostImagesTotal == 0){
  $postFieldToUpdate["has_images"] = "no";
}

//Check if post title has been change, if it has, check to ensure is unique.
 if($request->title != $request->previousTitle){
  // Check if post exist
     $postOutCome = Post::checkIfPostExist($newSlug);
     //If postOutCome has error, if so, redirect the user with system error msg.
     if($postOutCome["error"]){
      return redirect()
      ->route('admin.updatePostIndex',[$request->postId])
      ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
      ->withInput();
      die();
  }//End if out come error

   //If postOutCome has success, this means the there is a post with the same title,
   //Let the user know.
  if($postOutCome["success"]){

    return redirect()
    ->route('admin.updatePostIndex',[$request->postId])
    ->withErrors(["fail"=> "Sorry post title (".$request->title.") already exist, please choose another title."])
    ->withInput();
    die();
    
  }//End if out come success

   //Add to Field to update
    $postFieldToUpdate["title"] = $request->title;
    $postFieldToUpdate["slug"] = $newSlug;
}// end if post title has change

   //Update post data in DB
   Post::where('id', $request->postId)->update($postFieldToUpdate);

    if($request->hasCategoryChange == "yes"){
    //Because post category can be change by frontend, if that is the case
   //Delete all the category join table  records related to this post first and start fresh.
   PostsXCategory::where('post_id', $request->postId)->delete(); 
      //Store post and catgory id in join table
      //Find this method at the bottom of this class
     $this->updatePostAndCategoryJoinTable($request, $request->postId);
}//request->hasCategoryChange
     //dd($newSlug);
   //Finally redirect the user to notification page
     //set session data for notification page
     $msg = "Post Updated successfully thank you";
     $request->session()->put('redirectLink', route('blog.single',[$newSlug]));
     $request->session()->put('type', "success");
     $request->session()->put('msg', $msg);
     $request->session()->put('redirectTime', 1000);
     return redirect("/notification");
 } catch (\Exception $e) {
  //If error occure redirect to same page and show system error
        //dd($e);
        return redirect()
        ->route('admin.updatePostIndex',[$request->postId])
        ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
        ->withInput();
}

}//End updatePostSave

private function storeImageInDbAndCloudinary($request,$folderName,$postId,$totalNumberOfFiles){

$uploadOptions = array(
"folder" => "/icblog/postimgs/".$folderName."/",
"resource_type" => "image",
"quality" => "80", 
"width" => 768, 
"height" => 432, 
"crop" => "limit"
);


for ($x = 0; $x < $totalNumberOfFiles; $x++){
$postImage = new Postimage(); 
$response = $this->cloudinaryInstance()::upload($request->images[$x]->getRealPath(),$uploadOptions);
$original_file_name = $request->images[$x]->getClientOriginalName();
//dd($response);
$postImage->post_id = $postId;
$postImage->public_id = $response['public_id'];
$postImage->img_url = $response['secure_url'];
if(Str::contains($original_file_name, 'main')){
$postImage->img_type = "main";
}
$postImage->save();
}//End for loop

}//End method storeImageInDbAndCloudinary

private function updatePostAndCategoryJoinTable($request,$postId){
//$categoryArray = explode(",",$request->selectedCategories);
foreach($request->selectedCategories AS $category ){
$posts_x_category = new PostsXCategory();
$posts_x_category->post_id = $postId;
$posts_x_category->category_id  = $category['id'];
$posts_x_category->save();
}

}//End method Update post and category join table

private function checkPostId($postId){
 if($postId == "" || !is_numeric($postId)){
    return redirect()
    ->route('admin.dashboard')
    ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()]);

  }//end if id is empty or is not a number

}
    
}
