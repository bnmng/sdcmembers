@extends('main', [ 'title'=>'Person' ])

@section('content')
<div class="container-fluid">
    @include('includes.errors')

    <!-- Current People -->
    <div class="card card-default">
    
        <div class="card-header">
            <a href="{{ url('person') }}">People</a> - {{ $person->name_last }}
        </div>
        <div class="card-block">
	@if ( pathinfo($file, PATHINFO_EXTENSION)=='pdf') 
		<embed src="{{ url( 'viewfile/' . $file ) }}" type='application/pdf' style="width:100%; height:1000px" />
	@else
		<img src="{{ url( 'viewfile/' . $file ) }}" width="90%"/>
	@endif
        </div>
    </div> 
</div>
@endsection
