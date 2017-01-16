@extends('main', [ 'title'=>'Committees' ])
@section('content')
<div class="container-fluid">
    @include('includes.errors')
    <!-- Current Committees -->
    <div class="card card-default" id="committee_list">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('committee') }}">Committees</a> - List
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    Actions
                </div>
                <div class="col-md-2">
                    Name
                </div>
                <div class="col-md-2">
                    Short Name
                </div>
                <div class="col-md-1">
                    Members
                </div>
            </div>
        </div>
    @if (count($committees) > 0)
        <div class="card-block">
        @foreach ($committees as $committee)
            <div class="row">
                <div class="col-md-1">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="get" action="{{ url('committee/'.$committee->id) }}">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Show</button>
                            </form>
                        </div>
            @if ( Gate::allows('privilege', App\User::$privileges['edit committees'] ) )
                        <div class="col-md-6">
                            <form method="get" action="{{ url('committee/'.$committee->id.'/edit') }}">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                            </form>
                        </div>
            @endif
                    </div>
                </div>
                <div class="col-md-2">
                    {{ $committee->name_long }}
                </div>
                <div class="col-md-2">
                    {{ $committee->name_short }}
                </div>
                <div class="col-md-2">
                    {{ $committee->members->count() }}
                </div>
            </div>
            <hr/>
        @endforeach 
        </div>
    @endif
    </div> 

    @if ( Gate::allows( 'privilege', App\User::$privileges['edit committees'] ) )
    <div class="card card-default">
        <div class="card-header">
            <a href="{{ url('committee') }}">Committees</a> - Add
        </div>
        <div class="card-block">
            <form method="get" action="{{ url('committee/create') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">Add</button>
            </form>
        </div>
    </div>
    @endif
</div>

@section('script')
<script>
    $(document).ready( function () { 
        $( '#navlink_committee_a' ).addClass( 'active' );
        if ( $( '#committee_select ' ).length ) {
            $( '#committee_select_form' ).hide();
            $( '#committee_select_show_button' ).click( function( event ) {
                event.preventDefault();
                $( '#committee_select_form' ).toggle();
            });
        };
        $( '#committee_emails_show_div').html( '<button id="person_emails_show_button" class="btn btn-sm">Show Emails</button>' );
        $( '#committee_emails' ).hide();
        $( '#committee_emails_show_button' ).click( function() { $( '#person_emails' ).toggle(); } );
    });
</script>
@endsection
