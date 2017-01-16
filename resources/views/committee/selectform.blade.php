<div class="card card-default">
    <div class="card-header">
        People - Sort &amp; Filter
    </div>
    <div class="card-block">
        <div class="row" id="person_select_show_div">
            <div class="col-md-2">
                <button class="btn btn-sm btn-outline-primary" id="person_select_show_button">Filter/Sort</button>
            </div>
        </div>
        <form method="get" action="{{ url('person') }}" id="person_select_form">
            <div class="row">
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-md-12">
                            Sort By
                        </div>
                    </div>
@for ( $i = 0; $i < 3; $i++ )
                    <div class="row">
                        <div class="col-md-12">
                            <select name="orderby[{{ $i}}]">
    @foreach ( [ 'name_last' => 'Last Name', 'name_first' => 'First Name', 'membership_class' => 'Membership Class' ] as $value => $name )
                                <option value="{{ $value }}"
        @if ( isset( $parameters[ 'orderby'][ $i ] ) &&  $value == $parameters[ 'orderby' ][ $i ] ) )
                                selected="selected"
        @endif
                                >{{ $name }}</option>
    @endforeach
                            </select>
                        </div>
                    </div>
@endfor
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            Membership Class
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <select multiple="multiple" class="selectpicker" name="membership_class[]">
@foreach ( App\MembershipClass::orderBy('order')->get() as $membership_class )
                                <option value="{{ $membership_class->id }}"
    @if ( isset( $parameters[ 'membership_class'] ) && in_array( $membership_class->id, $parameters[ 'membership_class' ] ) )
                                selected="selected"
    @endif
                                >{{ $membership_class->name }}</option>
@endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            Membership Status
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <select multiple="multiple" class="selectpicker" name="status[]">
@foreach ( App\Status::orderBy('order')->get() as $status )
                                <option value="{{ $status->id }}"
    @if ( isset( $parameters[ 'status'] ) && in_array( $status->id, $parameters[ 'status' ] ) )
                                selected="selected"
    @endif
                                >{{ $status->name }}</option>
@endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            Committees
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <select multiple="multiple" class="selectpicker" name="committee[]">
@foreach ( App\Committee::orderBy('order')->get() as $committee )
                                <option value="{{ $committee->id }}"
    @if ( isset( $parameters[ 'committee'] ) && in_array( $committee->id, $parameters[ 'committee' ] ) )
                                selected="selected"
    @endif
                                >{{ $committee->name_long }}</option>
@endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <button id="person_select_submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
