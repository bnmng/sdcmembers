<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at' ];
}
