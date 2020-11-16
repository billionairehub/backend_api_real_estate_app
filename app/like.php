<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class like extends Model
{
    use SoftDeletes;
    public $table = 'like'; 
}
