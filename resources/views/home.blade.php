@extends('main', [ 'title'=>'' ]);

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
@if ( Auth::user()->is_new ) 
                    You are registered!  Please give the administrator a day or so to upgrade your privileges
@else
                    You are logged in!
@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
