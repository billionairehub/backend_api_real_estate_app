<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category_crawler extends Model
{
    use SoftDeletes;
    protected $table = 'category_crawler'; 
}
