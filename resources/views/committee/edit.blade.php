@extends('main', [ 'title'=>'Committee' ])

@section('content')

<div class="container-fluid">
    @include('includes.errors')

    <div class="card card-default">
        <div class="card-header">
            <a href="{{ url('committee') }}">Committees</a> - 
    @if ( isset ( $committee->id ) && $committee->id > 0 ) 
            {{ $committee->name_full }} - Edit
    @else 
            - Add
    @endif
        </div>
        <div class="card-block">
        <!-- Edit Committee Form -->
    @if ( isset( $committee->id ) && $committee->id > 0 )
            <form action="{{ url('committee/'.$committee->id)}}" method="POST" class="form-horizontal">
                {{ method_field('PUT') }}
    @else 
            <form action="{{ url('committee/')}}" method="POST" class="form-horizontal">
    @endif 
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="name_long" class="col-md-2">Name:</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name_long" value="{{ $committee->name_long }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name_short" class="col-md-2">Short Name</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name_short" value="{{ $committee->name_short }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="order" class="col-md-2">View Order</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="order" value="{{ $committee->order }}" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="members" class="col-md-2">Members</label>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 text-md-center">
                                Member
                            </div>
                            <div class="col-md-4 text-md-center">
                                Position
                            </div>
                            <div class="col-md-2 text-md-center">
                                Remove
                            </div>
                        </div>
    <?php $i = 0; ?>

    @foreach ( $committee->members as $committeemember )
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control" name="people[{{ $i }}][id]">
        @foreach ( App\Person::orderBy('name_last')->get() as $availableperson ) 
                                    <option value="{{ $availableperson->id }}"
            @if ( $availableperson->id == $committeemember->id )
                                    selected="selected"
            @endif
                                    >{{ $availableperson->name_short }} </option>
        @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text"  class="form-control" name="people[{{ $i }}][position]" value="{{ $committeemember->pivot->position }}" />
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="people[{{ $i }}][delete]" />
                            </div>
                        </div>
        <?php $i++ ?>
    @endforeach
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control" name="people[{{ $i }}][id]">
                                    <option value="">[Add Person]</option>
        @foreach ( App\Person::orderBy('name_last')->get()  as $availableperson )
                                    <option value="{{ $availableperson->id }}">{{ $availableperson->name_first }} {{ $availableperson->name_last }}</option>
        @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text"  class="form-control" name="people[{{ $i }}][position]" value="" />
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
    @if ( isset ( $committee->id ) && $committee->id > 0 )
    <div class="card card-default">
        <div class="card-header">
            <a href="{{ url('committee') }}">Committees</a> - {{ $committee->name }} - Delete
        </div>
        <div class="card-block">
            <form action="{{ url('committee/'.$committee->id.'/delete')}}" method="GET" class="form-horizontal">
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
        $( '#navlink_committee_a' ).addClass( 'active' );
    });
</script>
@endsection
