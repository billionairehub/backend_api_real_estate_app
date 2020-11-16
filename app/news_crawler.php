<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class news_crawler extends Model
{
    use SoftDeletes;
    protected $table = 'news_crawler'; 
}
