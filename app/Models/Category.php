<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model{
     
    use HasFactory;
    
    public static function checkIfCategoryExist($slug){
        $outComeArray = array("error"=>false, "success"=> false);
      
      try {
      
         $category = DB::table('categories')->where("slug", $slug)->first();
      
         if($category) {
            $outComeArray["success"] = true;
         }
      
         return $outComeArray;
      
        } catch (\Exception $e) { 
          $outComeArray["error"] = true;
          return $outComeArray;
        }
       
       }//End check if category exist

public static function fetchCategories($resultPerPage=0, $isAdmin=false, $defaultPaginate=false, $whereColumn="", $equalToValue="", $offSet=""){
      
  $categories = array();
     
      if($isAdmin){
        $query =  DB::table('categories')
        ->leftjoin('users AS A', 'A.id', '=', 'categories.created_by')
        ->leftjoin('users AS B', 'B.id', '=', 'categories.updated_by')
        ->select('categories.id','categories.name','categories.created_at','categories.updated_at','A.username as createdby_name','B.username as updatedby_name')
        ->orderBy('categories.id', 'desc');
        if($equalToValue !=""){
          $query->where('categories.'.$whereColumn,$equalToValue);
        }
       }else{
        $query = DB::table('categories')
        ->select('id','name')
        ->orderBy('categories.id', 'desc');
        if($equalToValue !=""){
          $query->where($whereColumn,$equalToValue);
        }
     }
  if($defaultPaginate){
      $categories = $query->paginate($resultPerPage);
  }else{
      if($offSet != ""){
         $query->offset($offSet);
       }
      if($resultPerPage > 0){
        $query->limit($resultPerPage);
      }

      
      $categories = $query->get();
 }

     //dd($categories); 
      return $categories;
  
  }//End fetchCategories

    
    public static function fetchCategoriesWithCount(){

      $outComeArray = array("error"=>false, "result"=> []);
      
      try {
        $outComeArray["result"] =  DB::table('categories')
        ->leftjoin('posts_x_categories AS X', 'X.category_id', '=', 'categories.id')
        ->select('categories.id','categories.name',DB::raw('count(X.category_id) as categoryPostTotal'))
        ->orderBy('categories.id', 'desc')
        ->groupBy('categories.id')
        ->get();
       
         return $outComeArray;
      
        } catch (\Exception $e) { 
          $outComeArray["error"] = true;
          return $outComeArray;
        }

}//End fetchCategoriesWithCount

public static function searchCategory($searchedWord){
  $outComeArray = array("error"=>false, "searchResult"=> []);

try {
       
  $outComeArray["searchResult"] = DB::table('categories')
                ->select('slug','name')
                ->where('name', 'LIKE', "%{$searchedWord}%")
                ->limit(10)
                ->get();

    return $outComeArray;

  } catch (\Exception $e) {
    //dd($e);
    $outComeArray["error"] = true;
    return $outComeArray;
  }
 
}//End searchPost



}


