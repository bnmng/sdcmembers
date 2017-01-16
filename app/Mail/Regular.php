<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class Regular extends Mailable
{
    use Queueable, SerializesModels;

    public $body;
    public $subjectline;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $subject, $body )
    {
        $this->subject = $subject;
        $this->body =  $body;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectline)->view( 'emails.regular' );
    }
}
