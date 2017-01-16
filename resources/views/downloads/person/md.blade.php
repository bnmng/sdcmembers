<?php 

$p = PDF_new();

if (PDF_begin_document($p, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($p));
}

PDF_set_info($p, "Title", "SDC List");

foreach ( $people as $person ) {

    $districttxt = '';
    $sep='';
    foreach( $person->districts as $district ) {
        $districttxt .= $sep;
        if( $district->district_type ) {
            $districttxt .= $district->district_type->name . ': ';
        }
        $districttxt .= $district->name;
        $sep=', ';
    }

    $phonetxt='';
    $sep='';
    foreach ( $person->phones as $phone ) {
        $phonetxt .= $sep . $phone->number;
        if ( $phone->can_text ) {
            $phonetxt.= " can text";
        }
        $sep=', ';
    }

    $emailtxt='';
    $sep='';
    foreach ( $person->emails as $email ) {
        $emailtxt .= $sep . $email->address;
        $sep=', ';
    }
    
    $statustxt = $person->status ? $person->status->name : '';
    $membershipclasstxt = $person->membership_class ? $person->membership_class->name : '';


    $csvline=array( 
            $person->name_friendly, 
            $person->name_last, 
            $person->name_full,
            $membershipclasstxt,
            $statustxt,
            $person->status ? $person->status->name : '( Undefined Status )',
            $phonetxt,
            $emailtxt,
            $districttxt,
            );
    fputcsv($fh, $csvline);
}


