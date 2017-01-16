<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Hash;

use App\User;

use Auth;

class UserController extends Controller
{
    private $validation_rules = [
        'name' => 'required|max:50|min:5',
        'email' => 'required|email',
        'role' => 'sometimes|numeric',
    ];

    /**
     * List Users
     */
    public function index() {

        $privilege = User::$privileges['view users'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $users=User::orderBy('name')->get();
        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * Show the Form to Create a User
     */

    public function create( ) {

        $privilege = User::$privileges['edit users'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $user = new User();
        $user->name = "[New]";
        $user->email = "";
        $user->role = 0;
        return view( 'admin.user.edit', ['user' => $user ] );
    }


    /**
     * Save the new User
     */

    public function store ( Request $request ) {

        $privilege = User::$privileges['edit users'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $input = $request->all();

        $user=new User;

        $this->validate($request, $this->validation_rules ); 

        $user->name = $request->name;
        $user->email = $request->email;

        $role = 0;
        foreach ( array_keys( $input['privilege'] ) as $i )  {
            $logi = floor( log( $input['privilege'][ $i ], 8 ) );
            foreach ( array_keys( $input['privilege'] ) as $j ) {
                if( !( $i == $j ) ) {
                    $logj = floor( log( $input['privilege'][ $j ], 8 ) );
                    if( $logi == $logj ) {
                        if( $input['privilege'][ $j ] <= $input['privilege'][ $i ] ) {
                            $input['privilege'][ $j ] = 0;
                        }
                    }
                }
            }
        }
        foreach ( $input['privilege'] as $privilege ) {
            $role = $role + $privilege;
        }
        $user->role = $role;
        
        $password = '';
        $chars=str_shuffle("abcdefghijklmnopqrstuvwxyz");
        for( $i=0; $i<4; $i++ ) {
            $password .= $chars[random_int(0,25)];
        }
        $chars=str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
        for( $i=0; $i<2; $i++ ) {
            $password .= $chars[random_int(0,25)];
        }
        $chars=str_shuffle("_*+@");
        for( $i=0; $i<2; $i++ ) {
            $password .= $chars[random_int(0,3)];
        }
        for( $i=0; $i<2; $i++ ) {
            $password .= random_int(0,9);
        }
        $password = str_shuffle( $password );

        $user->password = Hash::make( $password );

        $user->save();

        return ( view ( 'admin.user.show', ['user'=>$user] ) );

    }

    /**
     * Show an Individual User
     */
    public function show ( $id ) {

        $privilege = User::$privileges['view users'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $user=User::find($id);
        return view('admin.user.show', ['user' => $user] );

    }

    /**
     * Show the Form to Edit a User
     */

    public function edit( $id ) {

        $privilege = User::$privileges['edit users'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $user=User::find($id);
        return view( 'admin.user.edit', [ 'user' => $user ] );
        
    }


    /**
     * Update the edited user
     */

    public function update ( Request $request,  $id ) {

        $privilege = User::$privileges['edit users'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $input = $request->all();

        $user=User::find($id);

        $this->validate($request, $this->validation_rules ); 

        $user->name = $input['name'];
        $user->email = $input['email'];

        $role = 0;
        if( isset( $input['privilege'] ) ) {
            foreach ( array_keys(  $input['privilege'] ) as $i )  {
                $logi = floor( log( $input['privilege'][ $i ], 8 ) );
                foreach ( array_keys ( $input['privilege'] ) as $j ) {
                    if( !( $i == $j ) ) {
                        $logj = floor( log( $input['privilege'][ $j ], 8 ) );
                        if( $logi == $logj ) {
                            if( $input['privilege'][ $j ] <= $input['privilege'][ $i ] ) {
                                $input['privilege'][ $j ] = 0;
                            }
                        }
                    }
                }
            }
            foreach ( $input['privilege'] as $privilege ) {
                $role = $role + $privilege;
            }
        }
        $user->role = $role;

        $user->is_new = ( isset( $input['is_new'] ) );

        $user->save();

        return ( view ( 'admin.user.show', ['user'=>$user] ) );

    }

    /**
     * Display the Delete User confirmation form
     */
    public function delete ($id) {

        $privilege = User::$privileges['edit users'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $user=User::find($id);
        return view('admin.user.show', ['user' => $user, 'action' => 'delete' ]);

    }

    /**
     * Delete User
     */
    public function destroy ($id) {

        $privilege = User::$privileges['edit users'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        User::findOrFail($id)->delete();
        return redirect('/admin/user');

    }

}
