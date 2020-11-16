<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class post_detail extends Model
{
    use SoftDeletes;
    public $table = 'post_detail'; 
}
