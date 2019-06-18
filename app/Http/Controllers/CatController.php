<?php

namespace App\Http\Controllers;

use App\Http\Controllers\baseControllers\BaseController;

class CatController extends BaseController
{
  public function __construct()
  {
    $this->searchableField = ['name'];
    $this->model = "\App\Cat";
    $this->route = "cats";
    $this->fields = [
      [
        'field' => 'name',
        'type' => 'text'
      ],
      [
        'field' => 'age',
        'type' => 'number'
      ]
    ];
    $this->columns = ['name'];

  }
}