@extends('main', [ 'title'=>'People' ])
@section('content')
	<div class="container-fluid">
		@include('includes.errors')

		<!-- Select form -->
		<div class="card card-default hidden-print" id="person_select" >
			<div class="card-header">
				People - Sort &amp; Filter  
			</div>
			<div class="card-block" id="person_select_block">
				<form method="post" action="{{ url('person/select') }}" id="person_select_form">
				{{ csrf_field() }}
					<div id="filterby_name_div" class="filterby_section">
						<div class="row filterby_check">
							<div class="col-md-12" >
								<label class="form-check-label">
									<input type="checkbox" id="filterby_name_chk" name="filterby_name" class="form-check-input filterby_check" @if( isset( $parameters[ 'filterby_name' ] ) )checked="checked"@endif >
									Search By Name
								</label>
							</div>
						</div>
						<div class="row filterby_inputs">
							<div class="col-md-5 offset-md-1">
								<input type="text" name="name" value="@if ( isset ( $parameters['name'] ) ){{ $parameters['name'] }}@endif">
							</div>
						</div>
					</div>
					<div id="filterby_payments_div" class="filterby_section">
						<div class="row filterby_check">
							<div class="col-md-12">
								<label class="form-check-label">
									<input type="checkbox" id="filterby_payments_chk" name="filterby_payments" class="form-check-input filterby_check" @if( isset( $parameters[ 'filterby_payments' ] ) )checked="checked"@endif>
									Search By Payments
								</label>
							</div>
						</div>
						<div class="row filterby_inputs">
							<div class="col-md-2 offset-md-1">
								<select name="paydate_comparitor">
									<option value="">Any time</option>
									<option value="since" @if( isset( $parameters['paydate_comparitor'] ) && $parameters['paydate_comparitor'] == 'since' )selected="selected"@endif >Since</option>
									<option value="notsince" @if( isset( $parameters['paydate_comparitor'] ) && $parameters['paydate_comparitor'] == 'notsince' )selected="selected"@endif >Not Since</option>
								</select>
							</div>
							<div class="col-md-2">
								<input type="text" name="paydate_base" value="@if ( isset ( $parameters['paydate_base'] ) ){{ $parameters['paydate_base'] }}@endif">
							</div>
						</div>
					</div>
					<div id="filterby_membershipclass_div" class="filterby_section">
						<div class="row filterby_check" >
							<div class="col-md-12">
								<label class="form-check-label">
									<input type="checkbox" id="filterby_membershipclass_chk" name="filterby_membershipclass" class="form-check-input filterby_check" @if( isset( $parameters[ 'filterby_membershipclass' ] ) )checked="checked"@endif>
									Search By Membership Class
								</label>
							</div>
						</div>
						<div class="row filterby_inputs">
							<div class="offset-md-1 col-md-5">
								<select multiple="multiple"  name="membership_class[]" style="width:100%" >
@foreach ( App\MembershipClass::orderBy('order')->get() as $membership_class )
									<option value="{{ $membership_class->id }}"
	@if ( isset( $parameters[ 'membership_class'] ) && in_array( $membership_class->id, $parameters[ 'membership_class' ] ) )
									selected="selected"
	@endif
									>{{ $membership_class->name }}</option>
@endforeach
								</select>
							</div>
						</div>
					</div>
					<div id="filterby_status_div" class="filterby_section">
						<div class="row filterby_check" >
							<div class="col-md-12">
								<label class="form-check-label">
									<input type="checkbox" id="filterby_status_chk" name="filterby_status" class="form-check-input filterby_check" @if( isset( $parameters[ 'filterby_status' ] ) )checked="checked"@endif>
									Search By Status
								</label>
							</div>
						</div>
						<div class="row filterby_inputs">
							<div class="offset-md-1 col-md-5">
								<select multiple="multiple" class="selectpicker" name="status[]">
@foreach ( App\Status::orderBy('order')->get() as $status )
									<option value="{{ $status->id }}"
	@if ( isset( $parameters[ 'status'] ) && in_array( $status->id, $parameters[ 'status' ] ) )
									selected="selected"
	@endif
									>{{ $status->name }}</option>
@endforeach
								</select>
							</div>
						</div>
					</div>
					<div id="filterby_committees_div" class="filterby_section">
						<div class="row filterby_check" >
							<div class="col-md-12">
								<label class="form-check-label">
									<input type="checkbox" id="filterby_committees_chk" name="filterby_committees" class="form-check-input filterby_check" @if( isset( $parameters[ 'filterby_committees' ] ) )checked="checked"@endif>
									Search By Committees
								</label>
							</div>
						</div>
						<div class="row filterby_inputs">
							<div class="offset-md-1 col-md-5">
								<select multiple="multiple" class="selectpicker" name="committee[]">
@foreach ( App\Committee::orderBy('order')->get() as $committee )
									<option value="{{ $committee->id }}"
	@if ( isset( $parameters[ 'committee'] ) && in_array( $committee->id, $parameters[ 'committee' ] ) )
									selected="selected"
	@endif
									>{{ $committee->name_long }}</option>
@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							Sort By
						</div>
@for ( $i = 0; $i < 3; $i++ )
						<div class="col-md-2">
							<select name="orderby[{{ $i }}]">
	@foreach ( [ 'name_last' => 'Last Name', 'name_first' => 'First Name', 'membership_class' => 'Membership Class' ] as $value => $name )
								<option value="{{ $value }}"
			@if ( isset( $parameters[ 'orderby' ][ $i ] ) &&  $value == $parameters[ 'orderby' ][ $i ] ) 
								selected="selected"
			@endif
								>{{ $name }}</option>
	@endforeach
							</select>
						</div>
@endfor
					</div>
					<div class="row">
						<div class="col-md-2">
							<button id="person_select_submit" name="search" class="btn btn-sm btn-outline-primary" >&nbsp;&nbsp;&nbsp;Search&nbsp;&nbsp;&nbsp;</button>
						</div>
						<div class="col-md-2">
							<button name="set_default" type="submit" class="btn btn-sm btn-outline-primary"   >Search &amp; Set Default</button>
						</div>
						<div class="col-md-2">
							<button name="use_default" type="submit" class="btn btn-sm btn-outline-primary"   >Search With Default</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- End Select form -->


	    <!-- List -->
	    <div class="card card-default" id="person_list">
		<div class="card-header">
		    <div class="row ol1">
			<div class="col-md-12">
			    <a href="{{ url('person') }}">People</a> - List
			</div>
		    </div>
		    <div class="row ol1">
			<div class="col-md-2 offset-md-1">
			    Name
			</div>
			<div class="col-md-2">
			    Membershp
			</div>
			<div class="col-md-2">
			    Contact Information
			</div>
			<div class="col-md-2">
			    Districts
			</div>
			<div class="col-md-1">
			    Committees
			</div>
		    </div>
		</div>
	    <?php $email_list = ''; $no_email_list=''; ?>
	    <?php $quorum_list_count = 0;; ?>
	    @if (count($people) > 0)
		<div class="card-block">
		@foreach ($people as $person)
		    <div class="row ol1">
			<div class="col-md-1 hidden-print">
			    <div class="row">
				<div class="col-xs-6">
				    <form method="get" action="{{ url('person/'.$person->id) }}">
					<button type="submit" class="btn btn-sm btn-outline-primary">Show</button>
				    </form>
				</div>
		    @if ( Gate::allows('privilege', App\User::$privileges['edit people'] ) )
				<div class="col-xs-6">
				    <form method="get" action="{{ url('person/'.$person->id.'/edit') }}">
					<button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
				    </form>
				</div>
		    @endif
			    </div>
			</div>
			<div class="col-md-2">
		    @if ( $person->name_full > '' ) 
			    {{ $person->name_full }}
		    @else 
			    {{ $person->name_first }} {{ $person->name_last }} {{ $person->name_suffix }}
		    @endif
			</div>
			<div class="col-md-2">
			    <div class="row">
				<div class="col-md-12">
		    @if ( $person->membership_class )
				    {{ $person->membership_class->name }}
		    @else 
				    ( Undefined Membership Class )
		    @endif
				</div>
			    </div>
			    <div class="row">
				<div class="col-md-12">
		    @if ( $person->status )
				    {{ $person->status->name }}
		    @else
				    ( Undefined Status )
		    @endif
				</div>
			    </div>
			</div>       
		    @if ( Gate::allows('privilege', App\User::$privileges['view personal information'] ) )
			<div class="col-md-2">
			    <div class="row">
				<div class="col-md-12">
			@if ( $person->phones->first() ) 
				    {{ $person->phones->first()->number }}
			@endif
				</div>
			    </div>
			    <div class="row">
				<div class="col-md-12">
			@if ( $person->emails->first() ) 
				    <a href="mailto:{{ $person->emails->first()->address }}">{{ $person->emails->first()->address }}</a>
			    <?php 
			    if ( $email_list > '' ) {
				 $email_list .= ',';
			    }
			    $email_list .= $person->emails->first()->address;
			    ?>
			@else
			    <?php 
			    if ( $no_email_list > '' ) {
				 $no_email_list .= ', ';
			    }
			    $no_email_list .= $person->name_first . ' ' . $person->name_last;
			    ?>
			@endif
				</div>
			    </div>
			</div>
		    @endif
			<div class="col-md-2">
			    <div class="row">
		    @foreach ( $person->districts as $district )
				<div class="col-md-12">
				    {{ $district->district_type->name_short}}: {{ $district->name }}
				</div>
		    @endforeach 
			    </div>
			</div>
			<div class="col-md-2">
		    @if ( $person->committees ) 
			@foreach ( $person->committees as $committee ) 
			    <div class="row">
				<div class="col-md-12">
				    {{ $committee->name_short }}
				</div>
			    </div>
			@endforeach
		    @endif
			</div>
			<div class="col-md-1">
		    @if ( $person->is_quorum_member() ) 
			    quorum member
			<?php $quorum_list_count++ ; ?>
		    @endif
			</div>
		    </div>
		@endforeach 
		    <div class="row ol1">
			<div class="col-md-2">
				Members Listed: {{ $people->count() }}
			</div> 
			<div class="col-md-2">  
			    Committee Total of Quorum Members: {{ $quorum_count }}
			</div>
			<div class="col-md-2">  
			    This List Total of Quorum Members: {{ $quorum_list_count }}
			</div>
		@if ( Gate::allows('privilege', App\User::$privileges['view personal information'] ) )
			<div class="col-md-3" id="email_list" >  
			    <div class="row">
				<div class="col-md-12 email_list">
				    <form action="{{ url( 'email/regular' ) }}">
					<div class="row">
					    <div class="col-md-12">
						Email Addresses:
						<a href="mailto:{{ $email_list }}">{{ str_replace(',', ', ', $email_list) }}</a>
					    </div>
					</div>
				    </form>
				    <div class="row">
					<div class="col-md-12 email_list">
					    No emails listed for: 
					    {{ $no_email_list }}
					</div>
				    </div>
				</div>
			    </div>
			</div>    
		@endif
		    </div>
		</div>
	    @endif
	    </div> 
	    <!-- End List -->
	    
	    <!-- Add button -->
	    @if ( Gate::allows( 'privilege', App\User::$privileges['edit people'] ) )
	    <div class="card card-default">
		<div class="card-header">
		    <a href="{{ url('person') }}">People</a> - Actions
		</div>
		<div class="card-block">
		    <div class="row ol1">
			<div class="col-md-3">
			    <form method="get" action="{{ url('person/create') }}">
				<button type="submit" class="btn btn-sm btn-outline-primary">Add</button>
			    </form>
			</div>
			<div class="col-md-1">
			    <form method="get" action="{{ url('person/csv') }}">
				<button type="submit" class="btn btn-sm btn-outline-primary">CSV</button>
			    </form>
			</div>
			<div class="col-md-1">
			    <form method="get" action="{{ url('person/md') }}">
				<button type="submit" class="btn btn-sm btn-outline-primary">CSV</button>
			    </form>
			</div>
		    </div>
		</div>
	    </div>
	    @endif
	    <!-- End Add button -->

	</div>
@endsection


@section('script')
	<script>
		$(document).ready( function () { 
			$( '#navlink_person_a' ).addClass( 'active' );
			$( ".filterby_check" ).click( function ( event ) {
				refreshsearchfields();
			});
			refreshsearchfields();
			if ( $( '#email_list' ).length) {
				$( '.email_list' ).hide();
				$( '#email_list' ).prepend( '<div class="row"><div class="col-md-12"><button id="show_emails_button" class="">Show Emails</button></div></div>' );
				$( '#show_emails_button' ).click( function ( event ) {
					event.preventDefault();
					$( '.email_list' ).toggle();
				});
			}
			
		});
	function refreshsearchfields () {
		$( ".filterby_inputs" ).hide();	
		if ( $( "#filterby_name_chk" ).is( ":checked" ) ) {
			$( "#filterby_name_div" ).children().show();
		}
		if ( $( "#filterby_payments_chk" ).is( ":checked" ) ) {
			$( "#filterby_payments_div" ).children().show();
		}
		if ( $( "#filterby_membershipclass_chk" ).is( ":checked" ) ) {
			$( "#filterby_membershipclass_div" ).children().show();
		}
		if ( $( "#filterby_status_chk" ).is( ":checked" ) ) {
			$( "#filterby_status_div" ).children().show();
		}
		if ( $( "#filterby_committees_chk" ).is( ":checked" ) ) {
			$( "#filterby_committees_div" ).children().show();
		}
	}
	</script>
	@endsection
