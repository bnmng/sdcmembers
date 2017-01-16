<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Person extends Model
{

    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at' ];

    public function status( $prop='' ) {
        $status = $this->belongsTo( 'App\Status' );
        if ( $prop > '' ) {
            if ( $status->count() ) {
                $status = $status->first()->{ $prop };
            }
        }
        return $status;
    }

    public function membership_class( $prop='' ) {
        $membership_class = $this->belongsTo( 'App\MembershipClass' );
        if ( $prop > '' ) {
            if ( $membership_class->count() ) {
                $membership_class = $membership_class->first()->{ $prop };
            }
        }
        return $membership_class;
    }

    public function is_quorum_member () {
        $status = $this->status ;
        $membership_class = $this->membership_class ;

        return ( 
            $status &&
            $status->is_quorum  &&
            $membership_class &&
            $membership_class->is_quorum 
        ) ;
            
    }

    public function phones() {
        $phones = $this->hasMany('App\Phone')->orderBy('is_primary', 'desc')->orderBy('number');
        
        return $phones;
    }

    public function emails() {
        $emails = $this->hasMany('App\Email')->orderBy('is_primary', 'desc')->orderBy('address');
        
        return $emails;
    }

    public function districts( ) {

        $districts = $this->belongsToMany( 'App\District', 'residencies' )->with(['district_type' => function ( $query ) {
            $query->orderBy('order');
        }]);
        

        return $districts;
    }

    public function district( $district_type ) {

        $district = $this->belongsToMany( 'App\District', 'residencies' )->where( 'district_type_id', $district_type )->first();
        
        return $district;
    }

    public function committees () {
        
        $committees = $this->belongsToMany('App\Committee', 'committeememberships')->withPivot('position')->orderBy('order');

        return $committees;
    }

    public function payments() {
        $payments = $this->hasMany('App\Payment')->orderBy('when_effective', 'desc');
        
        return $payments;
    }
    public function applications() {
        $applications = $this->hasMany('App\Application')->orderBy('when', 'desc');
        
        return $applications;
    }


    public function canVote () {
        
    }

    
    
}
