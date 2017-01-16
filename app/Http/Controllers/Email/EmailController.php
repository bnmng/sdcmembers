<?php

namespace App\Http\Controllers\Email;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use App\Mail\Regular;
use Illuminate\Support\Facades\Gate;
use App\User;

class EmailController extends Controller 
{
    public function __construct() 
    {
        $this->middleware(['auth', 'checkuseren']);
    }
    /*display the form for drafting an email to the recipients selected in list view*/

    public function regular ( Request $request )
    {
        $privilege = User::$privileges['send email'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }
        $input = $request->input();
        return view('emails.regular.form', [ 'to' => $input['to'] ] );
    }

    /*Preview or send a drafted email */

    public function send_regular ( Request $request, $send=false )
    {
        $privilege = User::$privileges['send email'];
        if ( Gate::denies('privilege', $privilege) ) {
            return view('errors.unauthorized');
        }

        $input = $request->input();
//        Mail::to( $input['to'] )->send( new Regular( $input['subject'], $input['body'] ) );
        $body = $input['body'];
        $body = htmlentities($body);

        $allowed_tagnames = [
            'br',
            'div',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'p',
            'span',
        ];

        $tagstring = $allowed_tagnames[0];

        for( $i=1; $i<count($allowed_tagnames); $i++ ) {
            $tagstring .= '|' . $allowed_tagnames[ $i ];
        }

        foreach( $allowed_tagnames AS $tagname ) {
            $body = preg_replace_callback( '/&lt;(\/?)'.$tagname.'(.*?)&gt;/i', function ( $matches ) {
                $replacement = str_replace([ '&lt;', '&gt;', '&quot' ], ['<','>','"'], $matches[0] );
                return $replacement;
            }, $body );
        }
        if ( isset($input['send']) && 'send'==$input['send'] ) {
            Mail::to($input['to'])->send ( new Regular(  $input['subject'], $body ) );
            return view ( 'emails.regular.preview', [ 'to'=>$input['to'], 'subj'=>$input['subj'], 'body'=>$body, 'subject'=>$input['subject'] ] );
        }
        else {
            return view ( 'emails.regular.preview', [ 'to'=>$input['to'], 'subj'=>$input['subj'], 'body'=>$body, 'subject'=>$input['subject'] ] );
        }
    }
}
