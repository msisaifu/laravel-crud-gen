<?php

namespace App\baseModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cat extends Model
{
    use SoftDeletes;
    protected $fillable=['name'];
}