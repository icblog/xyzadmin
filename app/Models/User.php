<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{


  public static function updateLastLoginDate()
  {
    if (Auth::check()) {
      DB::table('users')->where('id', Auth::User()->id)->update(['last_login_date' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
  }


  public static function checkIfUserExist($fieldTocheck, $fieldValue)
  {
    $outComeArray = array("error" => false, "user" => null);

    try {

      $user = DB::table('users')->select("id")->where('xyz_app_access', 1)->where($fieldTocheck, $fieldValue)->first();

      $outComeArray["user"] = $user;

      //  if(!is_null($user)) {
      //     $outComeArray["user"] = $user;
      //  }

      return $outComeArray;
    } catch (\Exception $e) {
      $outComeArray["error"] = true;
      return $outComeArray;
    }
  } //End check if user exist

  public static function searchUser($searchedWord, $action = '')
  {
    $outComeArray = array("error" => false, "searchResult" => []);

    try {

      $query = DB::table('users');

      if ($action == 'with_department') {
        $query->select('users.id', 'users.fname', 'users.lname', 'department_and_companies.name AS department_name', 'department_and_companies.id AS department_id')
          ->join('department_and_companies', 'department_and_companies.id', '=', 'users.department_company');
      } else if ($action == 'edit') {
        $query->select('users.id', 'users.fname', 'users.lname', 'users.username', 'users.email', 'users.is_leader', 'users.phone', 'users.role', 'users.badge_id', 'users.xyz_app_access', 'department_and_companies.id AS department_id', 'department_and_companies.name AS department_name', 'department_and_companies.is_depart_or_comp AS is_depart_or_comp')
          ->join('department_and_companies', 'department_and_companies.id', '=', 'users.department_company');
      } else {
        $query->select('users.id', 'users.fname', 'users.lname', 'users.department_company', 'users.email', 'users.is_leader', 'users.locker', 'lockers.name AS locker_name')
          ->leftjoin('lockers', 'lockers.id', '=', 'users.locker');
      }



      $query->where([
        ['users.fname', 'LIKE', "%{$searchedWord}%"]
      ])
        ->orWhere([
          ['users.lname', 'LIKE', "%{$searchedWord}%"]
        ]);

       

      $outComeArray["searchResult"] = $query->limit(5)->get();

      //$outComeArray["searchResult"]

      return $outComeArray;
    } catch (\Exception $e) {
      dd($e);
      $outComeArray["error"] = true;
      return $outComeArray;
    }
  } //End searchUser


  public static function viewUsers(
    $sort_by = "",
    $searched_word = "",
    $paginate = false,
    $result_per_page = 6
  ) {

    switch ($sort_by) {

      case 'Latest':
        $sort_how = "DESC";
        $sort_by =  "id";
        $filter = "";
        break;
      case 'A-Z':
        $sort_how = "ASC";
        $sort_by =  "fname";
        $filter = "";
        break;
      case 'Z-A':
        $sort_how = "DESC";
        $sort_by =  "fname";
        $filter = "";
        break;
      case "Department":
        $sort_how = "DESC";
        $sort_by =  "id";
        $filter = 0;
        break;
      case "Company":
        $sort_how = "DESC";
        $sort_by =  "id";
        $filter = 1;
        break;
      default:
        $filter = "";
        $sort_how = "DESC";
        $sort_by =  "id";
    }

    $out_come_array = array('error' => false, 'view_users_data' => []);

    try {

      $query = DB::table('users')
        ->select('users.id', 'users.fname', 'users.lname', 'users.username', 'users.email', 'users.phone', 'users.badge_id', 'users.role', 'users.is_leader', 'users.xyz_app_access', 'users.created_at', 'users.updated_at', 'A.name AS department_name', 'A.is_depart_or_comp AS depart_or_comp', 'B.name AS locker_name')
        ->leftJoin('lockers AS B', function ($join) {
          $join->on('B.id', '=', 'users.locker');
        })
        ->leftJoin('department_and_companies AS A', function ($join) {
          $join->on('A.id', '=', 'users.department_company');
        });
      if ($searched_word != '') {
        $query->where([
          ['fname', 'LIKE', "%{$searched_word}%"]
        ]);
      }
      if ($filter === 0) {
        $query->where('A.is_depart_or_comp', '=', 0);
      }

      if ($filter === 1) {
        $query->where('A.is_depart_or_comp', '=', 1);
      }
      $query->orderBy($sort_by, $sort_how);

      if ($paginate) {
        $out_come_array['view_users_data'] = $query->paginate($result_per_page);
      } else {
        $out_come_array['view_users_data'] = $query->limit($result_per_page)
          ->get();
      }

      return $out_come_array;
    } catch (\Exception $e) {
      //dd($e);
      $out_come_array['error'] = true;
      return $out_come_array;
    }
  } //End viewUsers

  public static function findCoworkersOnly($searched_word = "") {


    $out_come_array = array('error' => false, 'co-worker_data' => []);

    try {

      $query = DB::table('users')
        ->select('users.id', 'users.fname', 'users.lname','users.email','users.department_company','A.name AS department_name', 'A.is_depart_or_comp')
        ->leftJoin('department_and_companies AS A', function ($join) {
          $join->on('A.id', '=', 'users.department_company');
        });
      if ($searched_word != '') {
        $query->where([
          ['fname', 'LIKE', "%{$searched_word}%"]
        ]);
      }
   
        $query->where('A.is_depart_or_comp', '=', 0);
      
        $query->orderBy('fname', 'ASC');

        $out_come_array['co-worker_data'] = $query->limit(5)
          ->get();
      

      return $out_come_array;
    } catch (\Exception $e) {
      //dd($e);
      $out_come_array['error'] = true;
      return $out_come_array;
    }
  } //End findCoworkersOnly

  public static function fetchCoworkerFirstAndLastName($coworker_id = 0)
  {
    $out_come_array = array("error" => false, "result" => []);

    try {
      $query =  DB::table('users')
        ->select('id', DB::raw('group_concat(DISTINCT users.fname," ",users.lname) AS co_worker_fullname'));
      if ($coworker_id > 0) {
        $query->where('id',  $coworker_id);
        $out_come_array['result'] = $query->first();
      } else {
        $out_come_array['result'] = $query->get();
      }
      //dd($out_come_array['result']);
      return $out_come_array;
    } catch (\Exception $e) {
      //dd($e);
      $out_come_array["error"] = true;
      return $out_come_array;
    }
  } //End fetchCoworkerDepartResponsiblePhone
}
