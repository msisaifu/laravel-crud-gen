<?php
namespace App\Helpers;

class SearchFilter{

  public static function filterd($model, $field, $cast = false, $limit = 20)
  {
    $obj = new self;
    $r = request()->all();
    $q = $r['q'] ?? '';

    if(count($r) > 0){
      $records = $obj->search($model,$r, $field, $cast, $limit);
      if($cast){
        return $records;
      }
    }else{
      if($cast){
        return $model;
      }
      $records = $model::orderBy('id', 'desc')->paginate($limit);
    }
    return ['data' => $records, 'q' => $q];
  }

  public static function search($model,$r, $field, $cast = false, $limit = 20)
  {
    $model = $model->where(function($q) use($field, $r) {
        $i = 0;
        if(isset($r['q'])){
          foreach($field as $val){
            if($i> 0){
              $q->orWhere($val, 'LIKE','%'.$r['q'].'%');
            }else{
              $q->where($val, 'LIKE','%'.$r['q'].'%');
            }
            $i++;
          }
        }
    });
    foreach($r as $key=>$val){
      if($key != 'q' && $key != 'page' && $val){
        $model = $model->where($key, $val);
      }
    }
    if($cast){
        return $model;
    }
    $obj = new self;
    $records = $model->orderBy('id', 'desc')->paginate($limit);
    return  $obj->customPaginate($records, $r);
  }

  public static function customPaginate(& $model,$r)
  {
    $param = '';
    foreach($r as $k=>$v){
      if($k != 'page' && $v){
        $param .= "{$k}={$v}&";
      }
    }
    $param = '?'.$param.'page';
    $customPaginate = str_replace('?page', $param, $model->links());
    $model->customPaginate = $customPaginate;
    return $model;
  }
}