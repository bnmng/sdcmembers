@extends('main', [ 'title'=>'User' ])

@section('content')

<div class="container-fluid">
@include('includes.errors')

    <div class="card card-default">
        <div class="card-header">
                <a href="{{ url('admin/user') }}">Users</a> - 
                    @if ( isset ( $user->id ) && $user->id > 0 ) 
                        {{ $user->name }} - Edit
                    @else 
                        - Add
                    @endif
        </div>
        <div class="card-block">
            <!-- Edit User Form -->
            @if ( isset( $user->id ) && $user->id > 0 )
                <form action="{{ url('admin/user/'.$user->id)}}" method="POST" class="form-horizontal">
                {{ method_field('PUT') }}
            @else 
                <form action="{{ url('admin/user/')}}" method="POST" class="form-horizontal">
            @endif 
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="name" class="col-md-2">Name:</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name" value="{{ $user->name }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-2">Email:</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="email" value="{{ $user->email }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">Privileges</div>
                    <div class="col-md-6">
                        <?php $x=0; ?>
                        @foreach ( App\User::$privileges AS $key => $value )
                        <div class="form-group row">
                            <label for="$privilege[{{ $x }}]" class="col-md-6">{{ $key }}:</label>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="privilege[{{ $x }}]" value="{{ $value }}"
                                @if ( in_array( $value, $user->privileges_enabled() ) ) 
                                    checked = "checked" 
                                @endif
                                />
                            </div>
                        </div>
                            <?php $x++; ?>
                        @endforeach
                        <div class="form-group row">
                            <label for="is_new" class="col-md-6">Is New</label>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="is_new" 
                                @if ( $user->is_new ) ) 
                                    checked = "checked" 
                                @endif
                                />
                            </div>
                        </div>
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
    @if ( isset ( $user->id ) && $user->id > 0 )
        <div class="card card-default">
            <div class="card-header">
                <a href="{{ url('admin/user') }}">Users</a> - {{ $user->name }} - Delete
            </div>
            <div class="card-block">
                <form action="{{ url('admin/user/'.$user->id.'/delete')}}" method="GET" class="form-horizontal">
                    <div class="form-group-row">
                        <div class="offset-md-2 col-md-6">
                            <button type="submit" class="btn btn-sm btn-outline-warning">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection

@section('script')
<script>
    $(document).ready( function () { 
        $( '#navlink_user_a' ).addClass( 'active' );
    });
</script>
@endsection
