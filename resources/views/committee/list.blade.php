    <div class="card card-default" id="committee_list">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('committee') }}">Committees</a> - List
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    Actions
                </div>
                <div class="col-md-2">
                    Name
                </div>
                <div class="col-md-2">
                    Short Name
                </div>
                <div class="col-md-1">
                    Order
                </div>
            </div>
        </div>
    @if (count($committees) > 0)
        <div class="card-block">
        @foreach ($committees as $committee)
            <div class="row">
                <div class="col-md-1">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="get" action="{{ url('committee/'.$committee->id) }}">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Show</button>
                            </form>
                        </div>
            @if ( Gate::allows('privilege', App\User::$privileges['edit committees'] ) )
                        <div class="col-md-6">
                            <form method="get" action="{{ url('committee/'.$committee->id.'/edit') }}">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                            </form>
                        </div>
            @endif
                    </div>
                </div>
                <div class="col-md-2">
                    {{ $committee->name_long }}
                </div>
                <div class="col-md-2">
                    {{ $committee->name_short }}
                </div>
                <div class="col-md-2">
                    {{ $committee->order }}
                </div>
            </div>
            <hr/>
        @endforeach 
        </div>
    @endif
    </div> 
