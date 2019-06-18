<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;

class SidebarGenerator{
  private $menu;
  private $activate = false;

  public function __construct()
  {
   $this->setMenu();
  }

  public function setMenu()
  {

    $this->menu = [
      'Menu|' => [
        'Dashboard|dashboard|fas fa-tachometer-alt' => [],
        'Users|users.index|fas fa-user' => [],
        //--menu--
				'Cats|cats.index|fas fa-user' => [],
				//--endmenu--
      ]
    ];
    $role = Auth::user()->role;
    $this->accessMenu($this->menu, Access::access($role));
  }
  //remove non accessible section
  public function accessMenu(&$menu,$access)
  {
    if(count($menu) == 0){
      return;
    }
    foreach($menu as $k => &$v) {
      $key = explode('|', $k);

      if(!in_array($key[0], $access)){
        unset($menu[$k]);
      }
      $this->accessMenu($v, $access);
    }
  }

  public static function  getMenu()
  {
    $obj = new self;
    foreach($obj->menu as $key => $val){
      echo '<li class="nav-divider">';
      echo str_replace('|', '', $key);
      echo "</li>\n";
      $obj->displayMenu($val);
    }
  }

  public function displayMenu($menu, $i = 0)
  {
    foreach($menu as $key => $val){
      list($section,$url,$icon) = explode('|',$key);
      $cRoute = request()->route()->getName();
      $route = !empty($url) ? $url : '#';
      $activate = ($route == $cRoute) ? 'active' : '';
      $targets = $section.'-'.$i;

      //child activate
      if(count($val) > 0){
        $this->recur($val);
        list($activate,$expanded,$show) = ['', 'false', ''];
        if($this->activate){
          $activate = 'active';
          $expanded = 'true';
          $show = 'show';
        }
      }
      //child activate

      $url = ($route != '#') ? route($route) : $route;

      $data = '';
      $data .= "<li class='nav-item'>\n";
      $data .= sprintf("<a class='nav-link %s' href='%s'",$activate, $url);
      if(count($val) > 0){
        $data .= sprintf("data-toggle='collapse' aria-expanded='%s' data-target='#%s' aria-controls='%s'", $expanded, $targets, $targets);
      }

      $data .= '>';
      if(!empty($icon)){
        $data .= sprintf("<i class=''></i>", $icon);
      }

      $data .= $section;
      $data .= "</a>\n";
      echo $data;

      //child list
      if(count($val) > 0){
        $childMenu = '';
        $childMenu .= sprintf("<div id='%s' class='collapse submenu %s' style=''>", $targets, $show);
        $childMenu .= sprintf("<ul class='nav flex-column'>");

        echo $childMenu;
        $i++;
        self::displayMenu($val, $i);
        echo sprintf(''."</ul></div>\n");
      }
      //child list

      $a = "</li>\n";
      echo $a;
      $i++;
    }
  }
  public function recur($arr, $k = null)
  {
    if (count($arr) == 0) {
      $cRoute = request()->route()->getName();
      $nurl = explode('|',$k)[1];
      if($cRoute == $nurl){
        $this->activate = true;
      }
      return;
    }
    foreach($arr as $k=>$ar) $this->recur($ar, $k);
  }
}