<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class follow extends Model
{
    use SoftDeletes;
    public $table = 'follow'; 
}
