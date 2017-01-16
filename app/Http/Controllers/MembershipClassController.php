<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Hash;

use App\Committee;
use App\Phone;
use App\Email;
use App\User;
use App\SavedQuery;
use App\CommitteeMembership;

use Auth;

class CommitteeController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'checkuseren']);
    }

    /**
     * Save Committee
     *
     * This is called by function store and function update
    */

    private function save( $request, $id ) {
        $privilege = User::$privileges['edit committees'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $validation_rules = [
        ];

        //$this->validate($request, $validation_rules ); 

        if( $id==0 ) {
            $committee = new Committee();
        }
        else {
            $committee=Committee::find($id);
        }

        $committee->name_long = $request->input('name_long');
        $committee->name_short = $request->input('name_short');
        $committee->order = $request->input('order');

        $committee->save();

        if ( $request->has('people') && is_array( $request->input('people') ) ) {
            $people=[ ];
            foreach ( $request->input('people') as $inputperson ) {
                if ( !(isset( $inputperson['delete'] ) ) 
                && isset( $inputperson['id'] ) 
                && is_numeric( $inputperson['id'] ) 
                && $inputperson['id'] > 0 ) {
                    if ( isset( $inputperson['position'] ) 
                    && $inputperson['position'] > '' ) {
                        $person = [ $inputperson['id'] => [ 'position' => $inputperson['position'] ] ];
                    } 
                    else {
                        $person = $inputperson['id'];
                    }
                    $people[] = $person;
                }
            }
            $committee->people()->sync( $people );
        }

        return $committee;
    }
    /**
     * List Committees
     */
    public function index() {

        $committees=Committee::orderBy('order')->orderBy('name_long')->get();
        return view('committee.index', ['committees' => $committees ]);
    }


    /**
     * Show the Form to Create a Committee
     */

    public function create( ) {

        $privilege = User::$privileges['edit committees'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $committee = new Committee();
        $committee->name_long = "[New]";
        $committee->name_short = "";
        $committee->order = 100;
        return view( 'committee.edit', ['committee' => $committee ] );
    }


    /**
     * Save the new Committee 
     */

    public function store ( Request $request ) {
        $committee = $this->save ($request, 0 );
        return ( view ( 'committee.show', ['committee'=>$committee] ) );
    }
    
    /**
     * Show an Individual Committee
     */
    public function show ( $id ) {

        $committee=Committee::find($id);
        return view('committee.show', ['committee' => $committee] );

    }

    /**
     * Show the Form to Edit a Committee
     */

    public function edit( $id ) {

        $privilege = User::$privileges['edit committees'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $committee=Committee::find($id);
        return view( 'committee.edit', [ 'committee' => $committee ] );
        
    }

    /**
     * Update the edited Committee
     */

    public function update ( Request $request,  $id ) {
        $committee = $this->save ( $request, $id  );
        return ( view ( 'committee.show', ['committee'=>$committee] ) );
    }

    /**
     * Display the Delete Committee confirmation form
     */
    public function delete ($id) {

        $privilege = User::$privileges['edit committees'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $committee=Committee::find($id);
        return view('committee.show', ['committee' => $committee, 'action' => 'delete' ]);
    }

    /**
     * Delete Committee
     */
    public function destroy ($id) {

        $privilege = User::$privileges['edit committees'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        Committee::findOrFail($id)->delete();
        return redirect('committee');

    }

}
