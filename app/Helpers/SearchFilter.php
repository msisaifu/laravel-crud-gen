<?php
namespace App\Helpers;

class SearchFilter{
  public static function filterd($model,$r, $field, $limit = 20)
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
    $obj = new self;
    $records = $model->orderBy('id', 'desc')->paginate($limit);
    return  $obj->customPaginate($records, $r);
  }
  public function customPaginate(& $model,$r)
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