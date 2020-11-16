<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class album extends Model
{
    use SoftDeletes;
    public $table = 'album';
}
