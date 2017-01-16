@extends('main', [ 'title'=>'Users' ])

@section('content')

<div class="container-fluid">
@include('includes.errors')

    <div class="card card-default">
        <div class="card-header">
                <a href="{{ url('admin/user') }}">Users</a> - Create User
        </div>
        <div class="card-block">
            <!-- Edit User Form -->
            <form action="{{ url('admin/user/')}}" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="name" class="col-md-2">Name:</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-2">Email:</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="email" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2">Privileges</div>
                    <div class="col-md-6">
                        <?php $x=0; ?>
                        @foreach ( App\User::$privileges AS $key => $value )
                            <div class="form-group row">
                                <label for="$privilege[{{ $x }}]" class="col-md-6">{{ $key }}:</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="checkbox" name="privilege[{{ $x }}]" value="{{ $value }}" />
                                </div>
                            </div>
                            <?php $x++; ?>
                        @endforeach
                    </div>
                </div>
                <div class="form-group-row">
                    <div class="offset-md-2 col-md-6">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
