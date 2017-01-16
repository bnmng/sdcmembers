@extends('main', [ 'title'=>'Events' ])
@section('content')
<div class="container-fluid">
    @include('includes.errors')
    <!-- Current Events -->
    <div class="card card-default">
        <div class="card-header">
            <a href="{{ url('event') }}">Events</a> - List
        </div>
    @if (count($events) > 0)
        <div class="card-block">
        @foreach ( $events as $event )
            <div class="row">
                <div class="col-md-1">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="get" action="{{ url('event/'.$event->id) }}">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Show</button>
                            </form>
                        </div>
            @if ( Gate::allows('privilege', App\User::$privileges['edit events'] ) )
                        <div class="col-md-6">
                            <form method="get" action="{{ url('event/'.$event->id.'/edit') }}">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                            </form>
                        </div>
            @endif
                    </div>
                </div>
                <div class="col-md-2">
                    {{ $event->name }}
                </div>
                <div class="col-md-2">
                    {{ $event->when }}
                </div>       
                <div class="col-md-2">
                    {{ $event->type }}
                </div>
                <div class="col-md-2">
                    {{ $event->attendee_count }}
                </div>
            </div>
        @endforeach 
        </div>
    @endif
    </div> 
    @if ( Gate::allows( 'privilege', App\User::$privileges['edit events'] ) )
    <div class="card card-default">
        <div class="card-header">
            <a href="{{ url('event') }}">Events</a> - Add
        </div>
        <div class="card-block">
            <form method="get" action="{{ url('event/create') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">Add</button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
