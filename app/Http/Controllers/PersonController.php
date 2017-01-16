<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Hash;

use App\CommitteeMembership;
use App\Application;
use App\District;
use App\Email;
use App\Payment;
use App\Person;
use App\Phone;
use App\SavedQuery;
use App\User;

use DB;

use Auth;

class PersonController extends Controller
{

	public function __construct() 
	{
		$this->middleware(['auth', 'checkuseren']);
	}

	/*
	   Count of total quorum members
	 */
	public function quorum_count () 
	{
		$quorum_count = DB::table('people')
			->join('membership_classes', 'people.membership_class_id', '=', 'membership_classes.id')
			->join('statuses', 'people.status_id','=','statuses.id')
			->select(DB::raw ( 'count(*) as quorum_count' ))
			->whereNull('people.deleted_at')
			->where('membership_classes.is_quorum', '=', 1)
			->where('statuses.is_quorum', '=', 1)
			->value('quorum_count');

		return $quorum_count;
	}


	/**
	 * Save Person
	 *
	 * This is called by function store and function update
	 */

	private function save( $request, $id ) 
	{
		$privilege = User::$privileges['edit people'];
		if ( Gate::denies('privilege', $privilege) ) {
			return view('errors.unauthorized');
		}

		$validation_rules = [
			'name_first' => 'required|max:50|min:1',
			'name_middles' => 'sometimes|max:50',
			'name_last' => 'sometimes|max:50',
			'name_prefix' => 'sometimes|max:10',
			'name_suffix' => 'sometimes|max:20',
			'name_friendly' => 'sometimes|max:20',
			'name_short' => 'sometimes|max:20',
			'name_short_formal' => 'sometimes|max:100',
			'name_full' => 'sometimes|max:200',
			'application.*.id' => 'sometimes|numeric',
			'application.*.file' => 'sometimes|mimes:jpeg,jpg,bmp,png,gif,svg,pdf',
			'application.*.when' => 'sometimes|date',
			'email.*.id' => 'sometimes|numeric',
			'email.*.address' => 'sometimes|email',
			'payment.*.id' => 'sometimes|numeric',
			'payment.*.when_effective' => 'sometimes|date',
			'payment.*.when_dated' => 'sometimes|date',
			'payment.*.amount' => 'sometimes|regex:/^\s*\$*\s*\d*\.?\d*\s*$/',
			'phone.*.id' => 'sometimes|numeric',
		];


		$this->validate($request, $validation_rules ); 

		if( 0 == $id ) {
			$person = new Person();
		}
		else {
			$person=Person::find($id);
		}

		$person->name_first = $request->input('name_first');
		$person->name_middles = $request->input('name_middles');
		$person->name_last = $request->input('name_last');
		$person->name_suffix = $request->input('name_suffix');
		$person->name_prefix = $request->input('name_prefix');
		$person->name_friendly = $request->input('name_friendly');
		$person->name_short = $request->input('name_short');
		$person->name_short_formal = $request->input('name_short_formal');
		$person->name_full = $request->input('name_full');
		$person->address = $request->input('address');
		$person->appformlink = $request->input('appformlink');
		$person->membership_class_id = $request->input('membership_class_id');
		$person->status_id = $request->input('status_id');

		if ( !( $person->name_friendly > '' ) ) {
			$person->name_friendly = $person->name_first;
		}
		if ( !( $person->name_short > '' ) ) {
			$person->name_short = trim( $person->name_friendly ) . ' ' . trim( $person->name_last );
		}
		if ( !( $person->name_short_formal > '' ) ) {
			$person->name_short_formal = trim( $person->name_prefix ) . ' ' .  trim( $person->name_last );
		}
		if ( !( $person->name_full > '' ) ) {
			$person->name_full = trim( $person->name_prefix ) . ' ' . trim( $person->name_first ) . ' ' . trim( $person->name_middles ) . ' ' . trim( $person->name_last ) . ' ' . trim( $person->name_suffix );
		}

		$person->save();

		foreach ( array_keys( $request->input('phone') ) as $key ) {
			$phonekey = 'phone.' . $key;
			$is_valid = (
					$request->has($phonekey . '.id') &&
					!($request->has($phonekey . '.delete')) &&
					$request->has($phonekey . '.number') 
				    );
			if ($request->input( $phonekey . '.id' ) > 0 ) {
				$phone = Phone::find( $request->input( $phonekey . '.id' ) );
				if( $phone ) {
					if ( $is_valid ) {
						$phone->number = $request->input( $phonekey . '.number' );
						$phone->can_text = $request->has( $phonekey . '.can_text' );
						$phone->is_primary =  $request->has( $phonekey . '.is_primary' );
						$phone->save();
					}
					else {
						$phone->delete();
					}
				}
			}  
			elseif ( 0 == $request->input( $phonekey . '.id' ) ) {
				if( $is_valid ) {
					$phone = new Phone;
					$phone->person_id = $person->id;
					$phone->number = $request->input( $phonekey . '.number' );
					$phone->can_text = $request->has( $phonekey . '.can_text' );
					$phone->is_primary = $request->has( $phonekey . '.is_primary' );
					$phone->save();
				}
			}
		}

		foreach ( array_keys( $request->input('email') ) as $key ) {
			$emailkey = 'email.' . $key;
			$is_valid = (
					$request->has($emailkey . '.id') &&
					!($request->has($emailkey . '.delete')) &&
					$request->has($emailkey . '.address') 
				    );
			if ($request->input( $emailkey . '.id' ) > 0 ) {
				$email = Email::find( $request->input( $emailkey . '.id' ) );
				if( $email ) {
					if ( $is_valid ) {
						$email->address = $request->input( $emailkey . '.address' );
						$email->is_primary =  $request->has( $emailkey . '.is_primary' );
						$email->save();
					}
					else {
						$email->delete();
					}
				}
			}  
			elseif ( 0 == $request->input( $emailkey . '.id' ) ) {
				if( $is_valid ) {
					$email = new Email;
					$email->person_id = $person->id;
					$email->address = $request->input( $emailkey . '.address' );
					$email->is_primary = $request->has( $emailkey . '.is_primary' );
					$email->save();
				}
			}
		}

		foreach ( array_keys( $request->input('payment') ) as $key ) {
			$paymentkey = 'payment.' . $key;
			$is_valid = (
					$request->has($paymentkey . '.id') &&
					!($request->has($paymentkey . '.delete')) &&
					$request->has($paymentkey . '.amount') &&
					$request->has($paymentkey . '.when_effective')
				    );
			if ($request->input( $paymentkey . '.id' ) > 0 ) {
				$payment = Payment::find( $request->input( $paymentkey . '.id' ) );
				if( $payment ) {
					if ( $is_valid ) {
						$payment->amount = $request->input( $paymentkey . '.amount' );
						$payment->method = $request->input( $paymentkey . '.method' );
						$payment->when_effective =  date( 'Y-m-d', strtotime( $request->input( $paymentkey . '.when_effective' ) ) );
						if ( $request->has( $paymentkey . '.when_dated' ) ) {
							$payment->when_dated = date( 'Y-m-d', strtotime( $request->input( $paymentkey  . '.when_dated' ) ) );
						};
						$payment->save();
					}
					else {
						$payment->delete();
					}
				}
			}  
			elseif ( 0 == $request->input( $paymentkey . '.id' ) ) {
				if( $is_valid ) {
					$payment = new Payment;
					$payment->person_id = $person->id;
					$payment->amount = $request->input( $paymentkey . '.amount' );
					$payment->method = $request->input( $paymentkey . '.method' );
					$payment->when_effective =  date( 'Y-m-d', strtotime( $request->input( $paymentkey . '.when_effective' ) ) );
					if ( $request->has( $paymentkey . '.when_dated' ) ) {
						$payment->when_dated = date( 'Y-m-d', strtotime( $request->input( $paymentkey  . '.when_dated' ) ) );
					};
					$payment->save();
				}
			}
		}

		/*************************************/
		foreach ( array_keys( $request->input('application') ) as $key ) {
			$applicationkey = 'application.' . $key;
			$is_valid = (
					$request->has($applicationkey . '.id') &&
					!($request->has($applicationkey . '.delete')) &&
					$request->has($applicationkey . '.when')
				    );
			if ($request->input( $applicationkey . '.id' ) > 0 ) {
				
				$application = Application::find( $request->input( $applicationkey . '.id' ) );
				if( $application ) {
					if ( $is_valid ) {
						$application->when =  date( 'Y-m-d', strtotime( $request->input( $applicationkey . '.when' ) ) );
						$application->save();
					}
					else {
						$application->delete();
					}
				}
			}  
			elseif ( 0 == $request->input( $applicationkey . '.id' ) ) {
				$is_valid = $is_valid && $request->hasFile($applicationkey . '.file');
				if( $is_valid ) {
					$application = new Application;
					$application->person_id = $person->id;
					$application->when =  date( 'Y-m-d', strtotime( $request->input( $applicationkey . '.when' ) ) );
					$path = $request->file( $applicationkey . '.file' )->store( 'uploads');
					$application->url = basename( $path );
					$application->save();
				}
			}
		}
		/*************************************/

		if ( $request->has('districts') && is_array ( $request->input('districts') ) ) {
			$districts=[ ];
			$district_type_ids=[ ];
			foreach ( $request->input('districts') as $inputdistrict ) {
				if ( isset( $inputdistrict['id'] ) 
						&& is_numeric( $inputdistrict['id'] ) 
						&& $inputdistrict['id'] > 0 ) {
					$district = District::find( $inputdistrict['id'] );
					if( $district && $district->district_type ) {
						$district_type_id = $district->district_type->id;
						if( !in_array( $district_type_id, $district_type_ids ) ) {
							$districts[ $inputdistrict['id'] ] = $inputdistrict['id'];
							$district_type_ids[] = $district_type_id;
						}
					}
				}
			}
			$person->districts()->sync( $districts );
		}

		if ( $request->has('committees') && is_array ( $request->input('committees') ) ) {
			$committees=[ ];
			foreach ( $request->input('committees') as $inputcommittee ) {
				if ( !(isset( $inputcommittee['delete'] ) ) 
						&& isset( $inputcommittee['id'] ) 
						&& is_numeric( $inputcommittee['id'] ) 
						&& $inputcommittee['id'] > 0 ) {
					if ( isset( $inputcommittee['position'] ) 
							&& $inputcommittee['position'] > '' ) {
						$committees[ $inputcommittee['id'] ] = [ 'position' => $inputcommittee['position'] ];
					} 
					else {
						$committees[ $inputcommittee['id'] ] = $inputcommittee['id'];
					}
				}
			}
			$person->committees()->sync( $committees );
		}

		return $person;
	}


	public function personSearch ( $parameters = [] ) 
	{
		$orderby = [ 'name_last', 'name_first', 'name_middles' ];

		for ( $i = 0; $i < 3; $i++ ) {
			if ( isset ( $parameters['orderby'][$i] ) ) {
				$orderby[ $i ] = $parameters['orderby'][ $i ];
			}
		}
		$people=Person::orderBy( $orderby[0] )->orderBy( $orderby[1] )->orderBy( $orderby[2] );

		if ( isset ( $parameters['filterby_name'] ) && isset($parameters['name'] ) && $parameters['name'] > '' ) {

			$people->where( function ( $query ) use ( $parameters ) {
					$query->whereRaw( 'concat_ws(" ", `name_friendly`,`name_prefix`,`name_first`,`name_middles`,`name_last`,`name_suffix`, `name_short`, `name_full` ) like ?', '%' . $parameters['name'] . '%'  );
					});
		}

		if ( isset( $parameters[ 'filterby_membershipclass' ] ) && isset ( $parameters[ 'membership_class' ] )  ) {
			if ( !is_array( $parameters[ 'membership_class' ] ) ) {
				$parameters[ 'membership_class' ] = array( $parameters[ 'membership_class' ] );
			}
			$people->where( function ( $query ) use ( $parameters ) {
					foreach ( $parameters[ 'membership_class' ] as $membership_class ) {
					$query->orWhere( 'membership_class_id', '=', $membership_class );
					}
					});
		}

		if ( isset ( $parameters[ 'filterby_status' ] ) && isset ( $parameters[ 'status' ] )  ) {
			if ( !is_array( $parameters[ 'status' ] ) ) {
				$parameters[ 'status' ] = array( $parameters[ 'status' ] );
			}
			$people->where( function ( $query ) use ( $parameters ) {
					foreach ( $parameters[ 'status' ] as $status ) {
					$query->orWhere( 'status_id', '=', $status );
					}
					});
		}

		if ( isset( $parameters[ 'filterby_committees' ] ) && isset ( $parameters[ 'committee' ] )  ) {
			if ( !is_array( $parameters[ 'committee' ] ) ) {
				$parameters[ 'committee' ] = array( $parameters[ 'committee' ] );
			}
			$people->whereIn( 'id', CommitteeMembership::whereIn('committee_id', $parameters[ 'committee' ])->pluck('person_id')->all() );
		}
		error_log ( 'Checking Payments ' . __file__ . ' ' . __line__  );

		if ( isset( $parameters[ 'filterby_payments' ] ) && isset ( $parameters['paydate_comparitor'] ) ){
			error_log ( 'Payment is set ' . __file__ . ' ' . __line__  );
			if( !isset( $parameters['paydate_base'] ) || $parameters['paydate_base']=='' ) {
				if( $parameters['paydate_comparitor'] == 'since' ) {
					$people->whereIn( 'id', Payment::where('when_effective', '>=', date('Y-m-d'))->pluck('person_id'));
				}
				elseif ( $parameters['paydate_comparitor'] == 'notsince' ) {
					$people->whereNotIn( 'id', Payment::where('when_effective', '>=', date('Y-m-d'))->pluck('person_id'));
				}   
			}
			elseif( strtotime( $parameters['paydate_base'] ) ) {
				if( $parameters['paydate_comparitor'] == 'since' ) {
					$people->whereIn( 'id', Payment::where('when_effective', '>=', date('Y-m-d', strtotime( $parameters['paydate_base'] )))->pluck('person_id'));
				}
				elseif ( $parameters['paydate_comparitor'] == 'notsince' ) {
					$people->whereNotIn( 'id', Payment::where('when_effective', '>=', date('Y-m-d', strtotime( $parameters['paydate_base'] )))->pluck('person_id'));
				}
			}
		}

		$people=$people->get();
		return ( $people );
	}


	/**
	 * List People
	 */
	public function index(  $parameterstring='' ) 
	{

		if ( $parameterstring == '' ) {
			$parameterstring = \App\SavedQuery::getQuery('person_lastSearch');
		}
		if ( $parameterstring == '' ) {
			$parameterstring = \App\SavedQuery::getQuery('person_defaultSearch');
		}

		parse_str( $parameterstring, $parameters );

		if( isset( $parameters['use_default'] ) ) {
			$parameterstring = \App\SavedQuery::getQuery('person_defaultSearch');
			SavedQuery::saveQuery('person_lastSearch', $parameterstring );
			parse_str( $parameterstring, $parameters );
		}
		else {
			if( isset( $parameters['set_default'] ) ) {
				SavedQuery::saveQuery('person_defaultSearch', $parameterstring );
			}
			SavedQuery::saveQuery('person_lastSearch', $parameterstring);
		}

		$people = $this->personSearch( $parameters );


		$quorum_count=$this->quorum_count();
		return view('person.index', ['people' => $people, 'quorum_count' => $quorum_count, 'parameters'=>$parameters ]);
	}

	/**
	 * Show the Form to Create a Person
	 */

	public function create( ) {

		$privilege = User::$privileges['edit people'];
		if ( Gate::denies('privilege', $privilege) ) {
			return view('errors.unauthorized');
		}

		$person = new Person();
		$person->name_first = '[New]';
		$person->name_middles = '';
		$person->name_last = '';
		$person->name_suffix = '';
		$person->name_prefix = '';
		$person->name_friendly = '';
		$person->name_short = '';
		$person->name_short_formal = '';
		$person->name_full = '';
		$person->address = '';
		$person->membership_class_id = 0;
		$person->status_id = 0;
		$person->appformlink = ''; 
		return view( 'person.edit', ['person' => $person ] );
	}

	/**
	 * Save the new Person
	 */

	public function store ( Request $request ) {
		$person = $this->save ($request, 0 );
		return ( view ( 'person.show', ['person'=>$person] ) );
	}

	/**
	 * Show an Individual Person
	 */
	public function show ( $id ) {

		$person=Person::find($id);
		return view('person.show', ['person' => $person] );

	}

	/**
	 * Show the Form to Edit a Person
	 */

	public function edit( $id ) {

		$privilege = User::$privileges['edit people'];
		if ( Gate::denies('privilege', $privilege) ) {
			return view('errors.unauthorized');
		}

		$person=Person::find($id);
		return view( 'person.edit', [ 'person' => $person ] );

	}

	/**
	 * Update the edited person
	 */

	public function update ( Request $request,  $id ) {

		$person = $this->save ( $request, $id  );
		return ( view ( 'person.show', ['person'=>$person] ) );
	}

	/**
	 * Display the Delete Person confirmation form
	 */
	public function delete ($id) {

		$privilege = User::$privileges['edit people'];
		if ( Gate::denies('privilege', $privilege) ) {
			return view('errors.unauthorized');
		}

		$person=Person::find($id);
		return view('person.show', ['person' => $person, 'action' => 'delete' ]);
	}

	/**
	 * Delete Person
	 */
	public function destroy ($id) {

		$privilege = User::$privileges['edit people'];
		if ( Gate::denies('privilege', $privilege) ) {
			return view('errors.unauthorized');
		}

		Person::findOrFail($id)->delete();
		return redirect('person');

	}

	public function csv()
	{

		$parameterstring = \App\SavedQuery::getQuery('person_lastSearch');

		parse_str( $parameterstring, $parameters );

		$people = $this->personSearch( $parameters );

		$quorum_count=$this->quorum_count();

		return response()-> view( 'downloads.person.csv', [ 'people'=>$people ],  200 )->withHeaders( 
				[
				'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
				'Content-type'        => 'text/csv',
				'Content-Disposition' => 'attachment; filename=sdcpeople.csv',
				'Expires'             => '0',
				'Pragma'              => 'public',
				]);
	} 

	public function md()
	{

		$parameterstring = \App\SavedQuery::getQuery('person_lastSearch');

		parse_str( $parameterstring, $parameters );

		$people = $this->personSearch( $parameters );

		$quorum_count=$this->quorum_count();

		return response()-> view( 'downloads.person.md', [ 'people'=>$people ],  200 )->withHeaders( 
				[
				'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
				'Content-type'        => 'application/pdf',
				'Content-Disposition' => 'attachment; filename=sdcpeople.pdf',
				'Expires'             => '0',
				'Pragma'              => 'public',
				]);
	}

	public function viewfile ( Request $request, $id, $file ) 
	{
		$person = Person::find($id); 
		return( view ('person/viewfile', [ 'person' => $person, 'file' => $file ] ) );
	}


	public function select ( Request $request ) {
		$parameters = $request->input();
		unset ( $parameters['_token'] );
		$parameterstring = http_build_query ( $parameters );
		return redirect( url( 'person/select/' . urlencode( $parameterstring ) ) );
	}


}
