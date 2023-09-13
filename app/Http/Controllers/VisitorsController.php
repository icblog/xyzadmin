<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Lib\AjaxPagination;


class VisitorsController extends BaseController{


  public function signOutVisitor(Request $request){

    if(!is_numeric($request->signedInId)){
      return response()->json([
                  'error' => $this->returnGenericSystemErrMsg()
       ]);
    }//End if   
    try{
          //if there is an id update database;
        $updatedResult = Visitor::where('id',$request->signedInId)
        ->update(['sign_out' => $request->currentDataTime]);

        return response()->json([
          'error' => ''
        ]);

      } catch (\Exception $e) {
        //dd($e);
        return response()->json([
          'error' => $this->returnGenericSystemErrMsg()
       ]);
            
    }// end try catch
 }

 public function sortCurrentVisitor(Request $request){
  if(!is_string($request->selectedSortOption)){
    return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
     ]);
  }//End if   
  try{
     
    $currentVisitorsResult = Visitor::findAllCurrentVisitors($request->selectedSortOption);
      
     if($currentVisitorsResult['error']){
        return response()->json([
          'error' => $this->returnGenericSystemErrMsg()
       ]);
      }


      return response()->json([
        'error' => '',
        'currentVisitorsResult' =>$currentVisitorsResult['currentVisitorsData']
     ]);
    
    } catch (\Exception $e) {
      //dd($e);
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg()
     ]);
          
  }// end try catch

 }

 public function viewAllVisitor(Request $request){
  if(!is_string($request->selectedSortOption)){
    return response()->json([
                'error' => $this->returnGenericSystemErrMsg()
     ]);
  }//End if  
  
  
  try{
     $resultPerPage = 20;
     $paginate = true;
     $totalRecords = 0;

     if($request->initialPageLoad == "yes" || $request->coworkerOrVisitorFname != '' || $request->isDateChanged){
        $totalRecords = Visitor::countVisitors($request->coworkerOrVisitorFname, $request->startDate, $request->endDate,$request->isDateChanged);
        
        if($totalRecords['error']){
          return response()->json([
            'error' => $this->returnGenericSystemErrMsg()
         ]);
        }
        $totalRecords = $totalRecords['viewAllVisitorsCount'];

      }else{
        
        $totalRecords = $request->totalRecords;
     
      }
        
      $params = array(
        "totalRows" => $totalRecords,
        "resultPerPage" => $resultPerPage,
        "pageNumber" => $request->pageNumber,
      );
      $ajaxPaginator = new AjaxPagination($params);
      $offSet = $ajaxPaginator->returnOffset();
      $lastPageNumber = $ajaxPaginator->returnLast();

     //findAllVisitors($orderBy='',$coworkerOrVisitorFname="", $startDate="", $endDate="",$isDateChanged="no")
    $viewAllVisitorsResult = Visitor::findAllVisitors(
      $request->selectedSortOption,
      $request->coworkerOrVisitorFname,
      $request->startDate,
      $request->endDate,
      $request->isDateChanged,
      $paginate,
      $resultPerPage,
      $offSet
    );
      
     if($viewAllVisitorsResult['error']){
        return response()->json([
          'error' => $this->returnGenericSystemErrMsg()
       ]);
      }
 

      return response()->json([
        'error' => '',
        'viewAllVisitorsResult' => $viewAllVisitorsResult['viewAllVisitorsData'],
        'initialPageLoad'=> 'no',
        'totalRecords'=> $totalRecords,
        'pageNumber'=> $request->pageNumber+1,
        'lastPageNumber' => $lastPageNumber, 
     ]);
    
    } catch (\Exception $e) {
     // dd($e);
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg()
     ]);
          
  }// end try catch

 }


//Remove this at later date
 public function resetCurrentVisitor(Request $request){

  try{

    Visitor::query()->update(['sign_out' => null]);
     
    $currentVisitorsResult = Visitor::findAllCurrentVisitors();
      
     if($currentVisitorsResult['error']){
        return response()->json([
          'error' => $this->returnGenericSystemErrMsg()
       ]);
      }


      return response()->json([
        'error' => '',
        'currentVisitorsResult' =>$currentVisitorsResult['currentVisitorsData']
     ]);
    
    } catch (\Exception $e) {
      //dd($e);
      return response()->json([
        'error' => $this->returnGenericSystemErrMsg()
     ]);
          
  }// end try catch

 }

    
}//end main class
