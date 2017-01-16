@extends('main', [ 'title'=>'Users' ])
@section('content')
    <div class="container-fluid">
        @include('includes.errors')
        <!-- Current Users -->
        <div class="card card-default">
            <div class="card-header">
                <a href="{{ url('admin/user') }}">Users</a> - List
            </div>
            @if (count($users) > 0)
                <div class="card-block">
                    @foreach ($users as $user)
                        <div class="row">
                            <div class="col-md-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form method="get" action="{{ url('admin/user/'.$user->id) }}">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Show</button>
                                        </form>
                                    </div>
                                    @if ( Gate::allows('privilege', App\User::$privileges['edit users'] ) )
                                        <div class="col-md-6">
                                            <form method="get" action="{{ url('admin/user/'.$user->id.'/edit') }}">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                {{ $user->name }}
                            </div>
                            <div class="col-md-4">
                                {{ $user->email }}
                            </div>
                            <div class="col-md-2">
                                {{ $user->role_name() }}
                            </div>
                        </div>
                    @endforeach 
                </div>
            @endif
        </div> 
        <div class="card card-default">
            <div class="card-header">
                <a href="{{ url('admin/user') }}">Users</a> - Add
            </div>
            <div class="card-block">
                <form method="get" action="{{ url('admin/user/create') }}">
                    <button type="submit" class="btn btn-sm btn-outline-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready( function () { 
        $( '#navlink_user_a' ).addClass( 'active' );
    });
</script>
@endsection
