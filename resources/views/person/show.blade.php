@extends('main', [ 'title'=>'Person' ])

@section('content')
<div class="container-fluid">
    @include('includes.errors')

    <!-- Current People -->
    <div class="card card-default">
    
        <div class="card-header">
            <a href="{{ url('person') }}">People</a> - {{ $person->name_last }}
    @if ( isset( $action ) && $action == 'delete' ) 
                - Delete
    @endif
        </div>
        <div class="card-block">
            
            <div class="row ol1">
                <div class="col-xs-2">
                   Full Name: 
                </div>
                <div class="col-xs-6">
                    {{ $person->name_full }}
                </div>
            </div>
            <div class="row ol1">
                <div class="col-xs-2">
                    Short Name:
                </div>
                <div class="col-xs-6">
                    {{ $person->name_short }}
                </div>
            </div>
            <div class="row ol1">
                <div class="col-xs-2">
                    Membership Class
                </div>
                <div class="col-xs-6">
                    {{ $person->membership_class ? $person->membership_class('name') : "" }}
                </div>
            </div>
            <div class="row ol1">
                <div class="col-xs-2">
                    Membership Status
                </div>
                <div class="col-xs-6">
                    {{ $person->status ? $person->status('name') : "" }}
                </div>
            </div>
            <div class="row ol1">
                <div class="col-xs-2">
                    Committees
                </div>
                <div class="col-xs-6">
                    @foreach ( $person->committees as $committee ) 
                        <div class="row">
                            <div class="col-xs-12">
                                {{ $committee->name_long }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @foreach ( App\DistrictType::get() as $district_type )
            <div class="row ol1">
                <div class="col-xs-2">
                    {{ $district_type->name_long }}
                </div>
                <div class="col-xs-6">
                    {{ $person->district( $district_type->id ) ? $person->district( $district_type->id )->name : "None" }}
                </div>
            </div>
        @endforeach
        @if ( Gate::allows('privilege', App\User::$privileges['view personal information'] ) )
            <div class="row ol1">
                <div class="col-xs-2">
                    Phones
                </div>
                <div class="col-xs-6">
           @foreach ( $person->phones as $phone )
                    <div class="row">
                        <div class="col-xs-12">
                            {{ $phone->number }}
                @if ( $phone->can_text ) 
                            ( Can Text )
                @endif
                        </div>
                    </div>
            @endforeach
                </div>
            </div> 
            <div class="row ol1">
                <div class="col-xs-2">
                    Emails
                </div>
                <div class="col-xs-6">
           @foreach ( $person->emails as $email )
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="mailto:{{ $email->address }}">{{ $email->address }}</a>
                        </div>
                    </div>
            @endforeach
                </div>
            </div> 
            <div class="row ol1">
                <div class="col-xs-2">
                   Can Vote 
                </div>
                <div class="col-xs-6">
                    {{ $person->is_voter }}
                </div>
            </div>
            <div class="row ol1">
                <div class="col-xs-2">
                    Pays Dues
                </div>
                <div class="col-xs-6">
                    {{ $person->is_duespayer}}
                </div>
            </div>
            <div class="row ol1">
                <div class="col-xs-2">
                    Last 5 payments
                </div>
                <div class="col-xs-6">
                    <div class="row">
                        <div class="col-xs-3">
                            Effective Date
                        </div>
                        <div class="col-xs-3">
                            Transaction Date
                        </div>
			<div class="col-xs-3">
				Method
			</div>
                        <div clss="col-xs-3">
                            Amount
                        </div>
                    </div>
           @foreach ( $person->payments->take(5) as $payment )
                    <div class="row">
                        <div class="col-xs-3">
                            {{ $payment->when_effective }}
                        </div>
                        <div class="col-xs-3">
                            {{ $payment->when_dated }}
                        </div>
                        <div class="col-xs-3">
                            {{ $payment->method }}
                        </div>
                        <div class="col-xs-3">
                             ${{ $payment->amount }}
                        </div>
                    </div>
            @endforeach
                </div>
            </div>
            <div class="row ol1">
                <div class="col-xs-2">
                    Last 5 Applications
                </div>
                <div class="col-xs-6">
                    <div class="row">
                        <div class="col-xs-3">
                            Date
                        </div>
                        <div class="col-xs-3">
                            View
                        </div>
                    </div>
           @foreach ( $person->applications->take(5) as $application )
                    <div class="row">
                        <div class="col-xs-3">
                            {{ $application->when }}
                        </div>
                        <div class="col-xs-3">
                            <a href="{{ url ( 'person/' . $person->id . '/viewfile/' . $application->url ) }}">view</a>
                        </div>
                    </div>
            @endforeach
                </div>
            </div>
        @endif
        @if ( Gate::allows('privilege', App\User::$privileges['edit people'] ) )
            <div class="row ol1">
                <div class="col-xs-2 offset-xs-2">
            @if ( isset( $action ) && $action=='delete' ) 
                    <form method="POST" action="{{ url('person/'.$person->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-sm btn-outline-warning">Confirm Delete</button>
                    </form>
            @else
                    <form method="get" action="{{ url('person/'.$person->id.'/edit') }}">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                    </form>
            @endif
                </div>
            </div>
        @endif
        </div>
    </div> 
</div>
@endsection

@section('script')
<script>
    $(document).ready( function () { 
        $( '#navlink_person_a' ).addClass( 'active' );
    });
</script>
@endsection
