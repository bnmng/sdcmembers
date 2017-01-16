@extends('main', [ 'title'=>'Roles' ])

@section('submain')

    <nav class="navbar navbar-dark bg-inverse">
      <a class="navbar-brand" href="#">Roles</a>
      <ul class="nav navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
    
        </div>
    </div>
</div>
@yield('content')
@endsection
