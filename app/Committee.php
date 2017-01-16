<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Committee extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at' ];

    public function members () {

        $members = $this->belongsToMany( 'App\Person', 'committeememberships' )->withPivot('position')->orderBy('name_last');
        $temp = $members->get();

        return $members;
    }
}
