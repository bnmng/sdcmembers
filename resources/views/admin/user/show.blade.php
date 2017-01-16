@extends('main', [ 'title'=>'User' ])

@section('content')
<div class="container-fluid">
@include('includes.errors')

    <!-- Current Users -->
    <div class="card card-default">
        
            <div class="card-header">
                <a href="{{ url('admin/user') }}">Users</a> - {{ $user->name }}
                @if ( isset( $action ) && $action == 'delete' ) 
                    - Delete
                @endif
            </div>
            <div class="card-block">
                
                    <div class="row">
                        <div class="col-md-2">
                            Name:
                        </div>
                        <div class="col-md-6">
                            {{ $user->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 offset-md-2">
                            @if ( isset( $action ) && $action=='delete' ) 
                                <form method="POST" action="{{ url('admin/user/'.$user->id) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-sm btn-outline-warning">Confirm Delete</button>
                                </form>
                            @else
                                <form method="get" action="{{ url('admin/user/'.$user->id.'/edit') }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                                </form>
                            @endif
                        </div>
                    </div>
                
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
