<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use Auth;

class SavedQuery extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at' ];

    static function getQuery ( $name ) {
        $parameterstring='';
        $user = Auth::user();
        if ( $user ) {
            $saved_query = self::firstOrCreate(['user_id' => $user->id, 'name' => $name ] );
            $parameterstring = $saved_query->querystring;
        }
        
        return $parameterstring;
    }

    static function saveQuery ( $name, $parameterstring ) {
        $user = Auth::user();
        if ( $user ) {
            $saved_query = self::firstOrCreate(['user_id' => $user->id, 'name' => $name] );
            if ( $saved_query ) {
                $saved_query->querystring = $parameterstring;
                $saved_query->save();
            }
        }
    }
    
}
