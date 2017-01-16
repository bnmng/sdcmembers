<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at' ];

    /* These are hex values */
    public static $role_names = [
        'Super Admin'                      =>  022222222, 
        'General Officer'                  =>  022122222, 
        'Treasurer'                        =>  002121211,
        'Membership Admin'                 =>  022122121,
        'Officer'                          =>  012111111,
        'Districts Admin'                  =>  000011002,
    ];

    public static $privileges = [
        'edit users'                       =>         02,
        'view users'                       =>         01,
        'edit people statuses'             =>        020,
        'view people statuses'             =>        010,
        'edit people'                      =>       0200,
        'view personal information'        =>       0100,
        'edit payments'                    =>      02000,
        'view payments'                    =>      01000,
        'edit membership and status types' =>     020000,
        'edit districts'                   =>    0200000,
        'edit committees'                  =>   02000000,
        'send email'                       =>  020000000,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function role_name() {
        $role_name = array_search( $this->role, self::$role_names );
        if ( $role_name === false ) {
            return ( 'unnamed: ' . $this->role );
        }
        else {
            return ( $role_name  );
        }
    }

    function privileges_enabled () {
        $privileges_enabled = [];
        foreach ( self::$privileges as $privilege ) {
            if ( ( $this->role % ( 8 * ( 8 ** ( floor ( log( $privilege, 8 ) ) ) ) ) - $this->role % ( 8 ** ( floor ( log( $privilege, 8 ) ) ) ) ) >= $privilege ) {
                    $privileges_enabled[] = $privilege;
            }
        } 
        
        return $privileges_enabled;
    }

}
