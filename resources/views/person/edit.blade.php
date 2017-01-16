@extends('main', [ 'title'=>'Person' ])

@section('content')

<div class="container-fluid">
    @include('includes.errors')

    <div class="card card-default">
        <div class="card-header">
            <a href="{{ url('person') }}">People</a> - 
    @if ( isset ( $person->id ) && $person->id > 0 ) 
            {{ $person->name_full }} - Edit
    @else 
            - Add
    @endif
        </div>
        <div class="card-block">
        <!-- Edit Person Form -->
    @if ( isset( $person->id ) && $person->id > 0 )
            <form action="{{ url('person/'.$person->id)}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                {{ method_field('PUT') }}
    @else 
            <form action="{{ url('person/')}}" method="POST" class="form-horizontal">
    @endif 
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="name_first" class="col-md-3">First Name:</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name_first" value="{{ $person->name_first }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name_middles" class="col-md-3">Middle Names:</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name_middles" value="{{ $person->name_middles }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name_last" class="col-md-3">Last Name:</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name_last" value="{{ $person->name_last }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="name_prefix" >Prefix/Suffix (ie. Mr, Ms, Capt, Rev / Jr, III, Esq. )</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="name_prefix" value="{{ $person->name_prefix }}"/>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="name_suffix" value="{{ $person->name_suffix }}"/>
                    </div>
                </div>
                <div id="more_names"><!-- place holder for javascript --></div>
                <div id="name_friendly_div" class="form-group row">
                    <label for="name_friendly" class="col-md-3">Friendly Name (Nickname) ( leave blank for First Name )</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name_friendly" value="{{ $person->name_friendly }}"/>
                    </div>
                </div>
                <div  id="name_short_div" class="form-group row">
                    <label for="name_short" class="col-md-3">Short Name ( leave blank for Friendly Name &amp;  Last Name )</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name_short" value="{{ $person->name_short }}"/>
                    </div>
                </div>
                <div id="name_formal_div" class="form-group row">
                    <label for="name_short_formal" class="col-md-3">Short Formal Name ( leave blank for Prefix &amp;  Last Name )</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name_short_formal" value="{{ $person->name_short_formal }}"/>
                    </div>
                </div>
                <div id="name_full_div" class="form-group row">
                    <label for="name_full" class="col-md-3">Full Name ( leave blank for Prefix, First Name, Middle Names, Last Name, &amp; Suffix )</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name_full" value="{{ $person->name_full }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phones" class="col-md-3">Phones</label>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 text-md-center">
                                Number
                            </div>
                            <div class="col-md-2 text-md-center">
                               Can Text 
                            </div>
                            <div class="col-md-2 text-md-center">
                                Is Primary
                            </div>
                            <div class="col-md-2 text-md-center">
                                Delete
                            </div>
                        </div>
    <?php $i=0; ?>
    @foreach ( $person->phones as $phone  ) 
                        <input type="hidden" name="phone[{{ $i }}][id]" value="{{ $phone->id }}"/>
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" type="text" name="phone[{{ $i }}][number]" value="{{ $phone->number }}"/>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="phone[{{ $i }}][can_text]" 
        @if ( $phone->can_text ) 
                                    checked="checked" 
        @endif
                                />
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="phone[{{ $i }}][is_primary]" 
        @if ( $phone->is_primary ) 
                                    checked="checked" 
        @endif
                                />
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="phone[{{ $i }}][delete]"/>
                            </div>
                        </div>
        <?php $i++; ?>
    @endforeach
                        <input type="hidden" name="phone[{{ $i }}][id]" value="0"/>
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" type="text" name="phone[{{ $i }}][number]" value=""/>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control " type="checkbox" name="phone[{{ $i }}][can_text]"/>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="phone[{{ $i }}][is_primary]"/>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="emails" class="col-md-3">Emails</label>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 text-md-center">
                                Address
                            </div>
                            <div class="col-md-2 text-md-center">
                                Is Primary
                            </div>
                            <div class="col-md-2 text-md-center">
                                Delete
                            </div>
                        </div>
    <?php $i=0; ?>
    @foreach ( $person->emails as $email  ) 
                        <input type="hidden" name="email[{{ $i }}][id]" value="{{ $email->id }}"/>
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" type="text" name="email[{{ $i }}][address]" value="{{ $email->address }}"/>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="email[{{ $i }}][is_primary]" 
        @if ( $email->is_primary ) 
                                    checked="checked" 
        @endif
                                />
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="email[{{ $i }}][delete]"/>
                            </div>
                        </div>
        <?php $i++; ?>
    @endforeach
                        <input type="hidden" name="email[{{ $i }}][id]" value="0"/>
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" type="text" name="email[{{ $i }}][address]" value=""/>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="email[{{ $i }}][is_primary]"/>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="membership_class_id" class="col-md-3">Member Class</label>
                    <div class="col-md-6">
                        <select class="form-control" name="membership_class_id">
                            <option value="0">[Select Membership Class]</option>
    @foreach ( App\MembershipClass::orderBy('order')->get() as $membership_class )
                            <option value="{{ $membership_class->id }}"
        @if( $membership_class->id == $person->membership_class_id )
                                selected = "selected"
        @endif
                            >{{ $membership_class->name }}</option>
    @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status_id" class="col-md-3">Status</label>
                    <div class="col-md-6">
                        <select class="form-control" name="status_id">
                            <option value="0">[Select Status]</option>
    @foreach ( App\Status::orderBy('order')->get() as $status )
                            <option value="{{ $status->id }}"
        @if( $status->id == $person->status_id )
                                selected="selected"
        @endif
                            >{{ $status->name }}</option>
    @endforeach
                        </select>
                    </div>
                </div>
    <?php $i = 0; ?>
    @foreach ( App\DistrictType::get() as $district_type )
                <div class="form-group row">
                    <label for="districts[{{ $i }}][id]" class="col-md-3">{{ $district_type->name_long }}</label>
                    <div class="col-md-6">
                        <select  class="form-control" name="districts[{{ $i }}][id]">
                            <option value="0">[{{ $district_type->name_long }}]</option>
        @foreach ( App\District::where('district_type_id', $district_type->id)->get() as $district )
                            <option value="{{ $district->id }}"
            @if ( $person->district( $district_type->id ) )
                @if ( $district->id == $person->district( $district_type->id )->id )
                            selected = "selected"
                @endif
            @endif
                            >{{ $district->name }}</option>
        @endforeach
                        </select>
                    </div>
                </div>
        <?php $i++; ?>
    @endforeach

                <div class="form-group row">
                    <label for="committees" class="col-md-3">Committees</label>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 text-md-center">
                                Committee
                            </div>
                            <div class="col-md-4 text-md-center">
                                Position
                            </div>
                            <div class="col-md-2 text-md-center">
                                Remove
                            </div>
                        </div>
    <?php $i = 0; ?>
    @foreach ( $person->committees as $personcommittee )
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control" name="committees[{{ $i }}][id]">
        @foreach ( App\Committee::orderBy('order')->orderBy('name_long')->get() as $availablecommittee ) 
                                    <option value="{{ $availablecommittee->id }}"
            @if ( $availablecommittee->id == $personcommittee->id )
                                    selected="selected"
            @endif
                                    >{{ $availablecommittee->name_long }}</option>
        @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text"  class="form-control" name="committees[{{ $i }}][position]" value="{{ $personcommittee->pivot->position }}" />
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="checkbox" name="committees[{{ $i }}][delete]" />
                            </div>
                        </div>
        <?php $i++ ?>
    @endforeach
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control" name="committees[{{ $i }}][id]">
                                    <option value="0">[Join Committee]</option>
        @foreach ( App\Committee::orderBy('order')->orderBy('name_long')->get() as $availablecommittee ) 
                                    <option value="{{ $availablecommittee->id }}">{{ $availablecommittee->name_long }}</option>
        @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text"  class="form-control" name="committees[{{ $i }}][position]" value="" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="payments" class="col-md-3">Payments</label>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3 text-md-center">
                                Effective Date
                            </div>
                            <div class="col-md-2 text-md-center">
                                Amount
                            </div>
                            <div class="col-md-3 text-md-center">
                                Method
                            </div>
                            <div class="col-md-3 text-md-center">
                                Trans Date
                            </div>
                            <div class="col-md-1 text-md-cente">
                                Remove
                            </div>
                        </div>
    <?php $i = 0; ?>
    @foreach ( $person->payments as $payment )
                        <input type="hidden" name="payment[{{ $i }}][id]" value="{{ $payment->id }}"/>
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="payment[{{ $i }}][when_effective]" value="{{ $payment->when_effective }}" />
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="payment[{{ $i }}][amount]" value="{{ $payment->amount }}" />
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="payment[{{ $i }}][method]" value="{{ $payment->method }}" />
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="payment[{{ $i }}][when_dated]" value="{{ $payment->when_dated }}" />
                            </div>
                            <div class="col-md-1">
                                <input class="form-control" type="checkbox" name="payment[{{ $i }}][delete]" >
                            </div>
                        </div>
        <?php $i++ ?>
    @endforeach
                        <input type="hidden" name="payment[{{ $i }}][id]" value="0"/>
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="payment[{{ $i }}][when_effective]" value="" />
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="payment[{{ $i }}][amount]" value="" />
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="payment[{{ $i }}][method]" value="" />
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="payment[{{ $i }}][when_dated]" value="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="applications" class="col-md-3">Applications</label>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3 text-md-center">
                                Date
                            </div>
                            <div class="col-md-3 text-md-center">
                               File 
                            </div>
                            <div class="col-md-1 text-md-cente">
                                Remove
                            </div>
                        </div>
    <?php $i = 0; ?>
    @foreach ( $person->applications as $application )
                        <input type="hidden" name="application[{{ $i }}][id]" value="{{ $application->id }}"/>
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="application[{{ $i }}][when]" value="{{ $application->when }}" />
                            </div>
                            <div class="col-md-3">
                                <a href="{{ url ( 'person/' . $person->id . '/viewfile/' . $application->url ) }}">view</a>
                            </div>
                            <div class="col-md-1">
                                <input class="form-control" type="checkbox" name="application[{{ $i }}][delete]" >
                            </div>
                        </div>
        <?php $i++ ?>
    @endforeach
                        <input type="hidden" name="application[{{ $i }}][id]" value="0"/>
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="application[{{ $i }}][when]" value="" />
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control" name="application[{{ $i }}][file]" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="offset-md-2 col-md-6">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if ( isset ( $person->id ) && $person->id > 0 )
    <div class="card card-default">
        <div class="card-header">
            <a href="{{ url('person') }}">People</a> - {{ $person->name }} - Delete
        </div>
        <div class="card-block">
            <form action="{{ url('person/'.$person->id.'/delete')}}" method="GET" class="form-horizontal">
                <div class="form-group row">
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
        $( '#navlink_person_a' ).addClass( 'active' );
        $( '#more_names' ).html('<div class="row"><div class="col-md-3"><button id="more_names_toggle_button" class="btn btn-sm btn-outline-primary">Show More Names</button></div></div>');         
        var more_names = '#name_friendly_div, #name_short_div, #name_formal_div, #name_full_div';
        $( more_names ).hide();
        $( '#more_names_toggle_button' ).click( function ( event ) {
            event.preventDefault();
            if ( $( more_names ).is( ':hidden' ) )  {
                $( more_names ).show();
                $( "#more_names_toggle_button" ).text( 'Hide More Names' );
            }
            else {
                $( more_names ).hide();
                $( "#more_names_toggle_button" ).text( 'Show More Names' );
            }
        });
            
    });
    
</script>
@endsection
