<?php

namespace App\Http\Controllers\Visitor;
use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Visitor;



class VisitorsController extends BaseController{
 
  public function currentVisitorsIndex(){
    $currentVisitorsResult = Visitor::findAllCurrentVisitors();
      
    if($currentVisitorsResult['error']){
      return redirect()
      ->route('currentvisitor.index')
      ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
      ->withInput();
     }
    return Inertia::render('visitors/CurrentVisitors',
    ['currentVisitorsRes'=> $currentVisitorsResult['currentVisitorsData'],
    'pageName'=>'visitor',
    ]);
  

}

public function viewAllVisitorsIndex(Request $request){

          $resultPerPage = $this->returnResultPerPageNumber();//Find this in base controller
          $paginate = true;
       
        $selectedSortOption = $request->has('selectedSortOption')? $request->selectedSortOption:"";
        $coworkerOrVisitorFname = $request->has('coworkerOrVisitorFname')? $request->coworkerOrVisitorFname:"";
        $startDate = $request->has('startDate')? $request->startDate:"";
        $endDate = $request->has('endDate')? $request->endDate:"";
        $isDateChanged = $request->has('isDateChanged')? $request->isDateChanged:"no";

          $viewAllVisitorsResult = Visitor::findAllVisitors(
         $selectedSortOption,
          $coworkerOrVisitorFname,
           $startDate,
            $endDate,
            $isDateChanged,
          $paginate,
          $resultPerPage);
          
         if($viewAllVisitorsResult['error']){
          return redirect()
            ->route('viewallvisitors.index')
            ->withErrors(["fail"=> $this->returnGenericSystemErrMsg()])
            ->withInput();
            
          }
    
           return Inertia::render('visitors/ViewAllVisitors',
            [
              'viewAllVisitorsRes'=> $viewAllVisitorsResult['viewAllVisitorsData'],
             ]
            );
 }



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


}//end sortCurrentVisitor

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
