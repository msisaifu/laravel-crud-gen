<?php
namespace App\Helpers;

class Access{
  public static function access($role, $for = 'M')
  {
    $access['A'] = [
      'Menu',
      'Dashboard',
      'Users@crud',
      'Notfound',
      //--section--
			'Cats',
			//--endsection--
    ];
    $access['U'] = [
      'Menu',
      'Dashboard',
      'Users',
      'Notfound'
    ];
    if($for == 'M' && $access[$role]){
      return self::accessForMenu($access[$role]);
    }
    if($access[$role]){
      return $access[$role];
    }
  }
  public static function accessForMenu($menu){
    $newArr = [];
    foreach($menu as $v){
      $sv = strstr($v, '@', true);
      if($sv){
        array_push($newArr, $sv);
      }else{
        array_push($newArr, $v);
      }
    }
    return $newArr;
  }
}