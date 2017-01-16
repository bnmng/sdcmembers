<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at' ];

   public function district_type () {
        return $this->belongsTo( 'App\DistrictType' );
   }

    public function district_type_order () {
        return $this->district_type->order;
    } 

}
