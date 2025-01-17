<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Visitor extends Model
{
   use HasFactory;
   /**
    * The table associated with the model.
    *
    * @var string
    */
   //no created_at and updated_at columns in db
   public $timestamps = false;



   public static function findAllCurrentVisitors($orderBy = '')
   {

      switch ($orderBy) {
         case 'A-Z':
            $sortHow = "ASC";
            $orderBy =  "fname";
            break;
         case 'Z-A':
            $sortHow = "DESC";
            $orderBy =  "fname";
            break;
         case 'Date ascending':
            $sortHow = "ASC";
            $orderBy =  "sign_in";
            break;

         case 'Date descending':
            $sortHow = "DESC";
            $orderBy =  "sign_in";
            break;
         default:
            $sortHow = "DESC";
            $orderBy =  "id";
      }

      $outComeArray = array('error' => false, 'currentVisitorsData' => []);

      try {
         $query = DB::table('visitors')

            ->select('id', 'fname', 'lname', 'badge', 'company', 'phone', 'sign_in', 'sign_out', 'visiting', 'reason')
            ->whereNull('sign_out')
            ->orderBy($orderBy, $sortHow);
         $outComeArray['currentVisitorsData'] = $query->get();

         return $outComeArray;
      } catch (\Exception $e) {

         $outComeArray['error'] = true;
         return $outComeArray;
      }
   }


   public static function findAllVisitors($orderBy = "", $coworkerOrVisitorFname = "", $startDate = "", $endDate = "", $isDateChanged = "no", $paginate = false, $resultPerPage = 6)
   {

      switch ($orderBy) {
         case 'A-Z':
            $sortHow = "ASC";
            $orderBy =  "fname";
            break;
         case 'Z-A':
            $sortHow = "DESC";
            $orderBy =  "fname";
            break;
         case 'Date ascending':
            $sortHow = "ASC";
            $orderBy =  "sign_in";
            break;

         case 'Date descending':
            $sortHow = "DESC";
            $orderBy =  "sign_in";
            break;
         default:
            $sortHow = "DESC";
            $orderBy =  "id";
      }

      $outComeArray = array('error' => false, 'viewAllVisitorsData' => []);
      //   $startDate = date("Y-m-d", strtotime( '-1 days' ) ); 
      //   $endDate = now()->format('Y-m-d');    
      try {

         $query = DB::table('visitors')

            ->select('id', 'fname', 'lname', 'badge', 'company', 'phone', 'sign_in', 'sign_out', 'visiting', 'reason');

         if ($coworkerOrVisitorFname != '') {
            $query->where([
               ['fname', 'LIKE', "%{$coworkerOrVisitorFname}%"]
            ])->orWhere([
               ['lname', 'LIKE', "%{$coworkerOrVisitorFname}%"]
            ]);
         }

         if ($isDateChanged == 'yes') {
            // $query->whereDate('sign_in', '>=', $startDate)
            // ->whereDate('sign_in', '<=', $endDate);
            $query->whereDate('sign_in', '>=', explode(" ", $startDate)[0])
               ->whereDate('sign_in', '<=', explode(" ", $endDate)[0]);
         }
         $query->orderBy($orderBy, $sortHow);


         if ($paginate) {
            $outComeArray['viewAllVisitorsData'] = $query->paginate($resultPerPage);
         } else {
            $outComeArray['viewAllVisitorsData'] = $query->limit($resultPerPage)
               ->get();
         }



         return $outComeArray;
      } catch (\Exception $e) {
         //dd($e);
         $outComeArray['error'] = true;
         return $outComeArray;
      }
   }


   //  public static function countVisitors($coworkerOrVisitorFname="", $startDate="", $endDate="",$isDateChanged="no"){

   //    $outComeArray = array('error'=>false,'viewAllVisitorsCount'=> 0);

   //       try {

   //          $query = DB::table('visitors');

   //            if($coworkerOrVisitorFname !=''){
   //                $query->where([
   //                   ['fname', 'LIKE', "%{$coworkerOrVisitorFname}%"]
   //                ]);
   //             }

   //             if($isDateChanged =='yes'){
   //                $query->whereDate('sign_in', '>=',explode(" ",$startDate)[0])
   //                ->whereDate('sign_in', '<=', explode(" ",$endDate)[0]);
   //             }

   //               $outComeArray['viewAllVisitorsCount'] = $query->count();

   //         return $outComeArray;

   //          } catch (\Exception $e) {

   //             $outComeArray['error'] = true;
   //             return $outComeArray;

   //          }


   //  }

}// End main class
