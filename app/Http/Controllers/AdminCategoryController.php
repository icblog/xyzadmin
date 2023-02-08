<?php
namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\PostsXCategory;


//METHODS USED FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
// ajaxPaginationInstance


//METHODS USED FROM HELPER TRIAT FROM BASE CONTROLLER CLASS WHICH THIS CLASS EXTENDS
//returnReplacedStr
//returnGenericSystemErrMsg
//returnTimeStamp


class AdminCategoryController extends BaseController{ 

    private $resultPerPage = 2;

     public function categoriesIndex(Request $request){
    
       $categoriesResult = Category::fetchCategories($this->resultPerPage,true,true);
        if(!$categoriesResult){
         return redirect()
        ->route('admin.categoriesIndex')
        ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()]);
        }else{

            return Inertia::render('admin/Categories', ["categoriesResult"=>$categoriesResult]);
        }
    }//End categoriesIndex
  
  
  
  public function createCategory(Request $request){
         
   $validator = Validator::make($request->all(), [
      'categoryname' => 'required|string',
     
    ]); 
  
   if ($validator->fails()) {
     return response()->json([
         'outcome' => $validator->errors()->all()
     ]);
     die();
   }//end if validation

  //Generate a slug
   $slug  = $this->returnReplacedStr($request->categoryname," ","-");


   // Check if category exist
   $categoryOutCome = Category::checkIfCategoryExist($slug);
  
   if($categoryOutCome["error"]){
    return response()->json([
        'outcome' => [$this->returnGenericSystemErrMsg()]
    ]);
   die();
 }//End if out come error

 if($categoryOutCome["success"]){
  return response()->json([
      'outcome' => ["Sorry category name (".$request->categoryname.") already exist, please choose another name."]
  ]);
 die();
}//End if out come success

 //Save data in DB

 try {

     $category = new Category();
      $category->created_by = Auth::user()->id;
       $category->name = $request->categoryname;
       $category->slug = $slug;
       $category->save();
       return response()->json([
             "outcome" => true,
          ]);
  } catch (\Exception $e) {

        return response()->json([
          'outcome' => [$this->returnGenericSystemErrMsg()],
         
        ]);
 }

}

public function updateCategory(Request $request){

  $validator = Validator::make($request->all(), [
    'categoryId' => 'required|integer',
    'editedCategoryName' => 'required|string',
    'oldCategoryname' => 'required|string'
   
  ]); 

 if ($validator->fails()) {
   return response()->json([
       'outcome' => $validator->errors()->all()
   ]);
   die();
 }//end if validation

   //Check if editedCategoryName == oldCategoryname
   if($request->oldCategoryname == $request->editedCategoryName){
    return response()->json([
      'outcome' => ["Please make changes before saving"]
    ]);
    die();
   }

   //Generate a slug
   $slug  = $this->returnReplacedStr($request->editedCategoryName," ","-");
    
   // Check if category exist
    $categoryOutCome = Category::checkIfCategoryExist($slug);
  
    if($categoryOutCome["error"]){
     return response()->json([
         'outcome' => [$this->returnGenericSystemErrMsg()]
     ]);
    die();
  }//End if out come error
 
  if($categoryOutCome["success"]){
   return response()->json([
       'outcome' => ["Sorry category name (".$request->editedCategoryName.") already exist, please choose another name."]
   ]);
  die();
 }//End if out come success

   //Update catgories Db records
   
   try {
   
   $updatedCategoryRes = Category::where('id', $request->categoryId)->update(['updated_by' => Auth::user()->id,'name' => $request->editedCategoryName, 'slug'=>$slug]);
  
    if($updatedCategoryRes > 0){
        $updatedCategoryRecord = Category::fetchCategories(1,true,false,"id",$request->categoryId);
       // dd($updatedCategoryRecord);
        if(!$updatedCategoryRecord){
          return response()->json([
            'outcome' =>  [$this->returnGenericSystemErrMsg()],
          ]);
         }else{
          return response()->json([
                  "outcome" => true,
                  "updatedCategoryRecord" => $updatedCategoryRecord
              ]); 
         }
      
      }else{
        return response()->json([
            'outcome' =>  [$this->returnGenericSystemErrMsg()],
          ]);
    }
  
 } catch (\Exception $e) {
       
      return response()->json([
         'outcome' => $this->returnGenericSystemErrMsg(),
       ]);
   }

}//End updateCategory

public function deleteCategory(Request $request){

 if ($request->categoryId == "" || !is_numeric($request->categoryId)) {
      return response()->json([
       'outcome' => $this->returnGenericSystemErrMsg(),
     ]);
     die();
   }// end if request is empty

   //If no errors delete category
     try {
      Category::where('id', $request->categoryId)->delete();
      PostsXCategory::where('category_id', $request->categoryId)->delete();
       return response()->json([
       "outcome" => true
     ]);
   } catch (\Exception $e) {
          //dd($e);
    return response()->json([
    'outcome' => $this->returnGenericSystemErrMsg(),

   ]);

}

}//End delete



}//End class