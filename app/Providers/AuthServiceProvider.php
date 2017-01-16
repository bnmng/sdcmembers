<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-self', function ( $this_user, $subj_user_id = 0 )  {
            if ( $this_user->is_admin ) {
                return true;
            }
            if ( $this_user->id == $subj_user_id ) {
                return true;
            }
            return false;
        });

        Gate::define('privilege', function ( $user, $privilege ) {

            $role = $user->role;
            return ( ( $role % ( $privilege * 8 ) ) - ( $role % $privilege )  >= $privilege ) ;

        });
    }
}
