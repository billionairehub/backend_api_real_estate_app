<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class news extends Model
{
    use SoftDeletes;
    public $table = 'news'; 
}
