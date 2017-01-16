@extends('main', [ 'title'=>'Committee' ])

@section('content')
<div class="container-fluid">
    @include('includes.errors')

    <!-- Current Committees -->
    <div class="card card-default">
    
        <div class="card-header">
            <a href="{{ url('committee') }}">Committees</a> - {{ $committee->name_last }}
    @if ( isset( $action ) && $action == 'delete' ) 
                - Delete
    @endif
        </div>
        <div class="card-block">
            
            <div class="row">
                <div class="col-md-2">
                   Full Name: 
                </div>
                <div class="col-md-6">
                    {{ $committee->name_long }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    Short Name:
                </div>
                <div class="col-md-6">
                    {{ $committee->name_short }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                   Viewing Order 
                </div>
                <div class="col-md-6">
                    {{ $committee->order }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    Members
                </div>
                <div class="col-md-6">
                    <?php $email_list = ''; $no_email_list=''; ?>
                    @foreach ( $committee->members as $person ) 
                    <div class="row">
                        <div class="col-md-12"> 
                            {{ $person->name_first }} {{ $person->name_last }}
                            @if ( $person->emails->first() ) 
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
                    @endforeach
                </div>
            </div>
            <div class="row" id="person_emails">
                <div class="col-md-2">
                    Member Emails
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            {{ $email_list }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            No emails listed for 
                            {{ $no_email_list }}
                        </div>
                    </div>
                </div>
            </div>
        @if ( Gate::allows('privilege', App\User::$privileges['edit committees'] ) )
            <div class="row">
                <div class="col-md-2 offset-md-2">
            @if ( isset( $action ) && $action=='delete' ) 
                    <form method="POST" action="{{ url('committee/'.$committee->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-sm btn-outline-warning">Confirm Delete</button>
                    </form>
            @else
                    <form method="get" action="{{ url('committee/'.$committee->id.'/edit') }}">
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
