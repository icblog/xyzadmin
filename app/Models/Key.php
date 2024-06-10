<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Key extends Model
{
  use HasFactory;

  public static function fetchKeys(
    $filer_by = '',
    $searched_word = "",
    $paginate = false,
    $result_per_page = 6,
    $storage_id = 0
  ) {

    $out_come_array = array('error' => false, 'keys_data' => []);

    try {

      $query = DB::table('keys')
        ->select('keys.*', 'A.fname AS created_by_f', 'A.lname AS created_by_l', 'B.fname AS updated_by_f', 'B.lname AS updated_by_l', 'C.name AS storage_name')
        ->leftjoin('users AS A', 'A.id', '=', 'keys.created_by')
        ->leftjoin('users AS B', 'B.id', '=', 'keys.updated_by')
        ->leftjoin('key_storages AS C', 'C.id', '=', 'keys.storage_id');
      if ($searched_word  != '') {
        $query->where([
          ['keys.name', 'LIKE', "%{$searched_word}%"]
        ])->orWhere([
          ['keys.description', 'LIKE', "%{$searched_word}%"]
        ]);
      }

      if ($filer_by == 'Free') {
        $query->where('status', 0);
      }

      if ($filer_by  == 'Inuse') {
        $query->where('status', 1);
      }

      if ($filer_by == 'Lost') {
        $query->where('status', 2);
      }

      if ($storage_id > 0) {
        $query->where('storage_id', $storage_id);
      }

      $query->orderBy('id', 'DESC');


      if ($paginate) {
        $out_come_array['keys_data'] = $query->paginate($result_per_page);
      } else {
        $out_come_array['keys_data'] = $query->limit($result_per_page)
          ->get();
      }

      return $out_come_array;
    } catch (\Exception $e) {
      //dd($e);
      $out_come_array['error'] = true;
      return $out_come_array;
    }
  } //End fetchkeys

  public static function fetchAKeyForUpdate($key_id)
  {

    $out_come_array = array('error' => false, 'key_data' => []);

    try {

      $query = DB::table('keys')
        ->select('keys.id', 'keys.name', 'keys.description', 'keys.comment', 'keys.status', 'A.id AS storage_id', 'A.name AS storage_name')
        ->leftjoin('key_storages AS A', 'A.id', '=', 'keys.storage_id')
        ->where('keys.id', $key_id);

      $out_come_array['key_data'] = $query->first();

      return $out_come_array;
    } catch (\Exception $e) {

      $out_come_array['error'] = true;
      return $out_come_array;
    }
  } //End fetchAKeyForUpdate

  public static function findAkey($id = 0, $search_word = "")
  {
    $out_come_array = array("error" => false, "key_data" => []);

    $query = DB::table('keys')
      ->select('id', 'name', 'description', 'comment', 'status');
    if ($id > 0) {
      $query->where('id', $id);
      $out_come_array['key_data'] = $query->first();
    } else {
      $query->where([
        ['name', 'LIKE', "%{$search_word}%"]
      ]);
      $out_come_array['key_data'] = $query->limit(8)->get();
    }

    return $out_come_array;
  } //end find A key

}//End class
