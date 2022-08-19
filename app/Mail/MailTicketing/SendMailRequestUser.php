<?php

namespace App\Mail\MailTicketing;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailRequestUser extends Mailable
{
    use Queueable, SerializesModels;

    private $header;
    private $detail;
    private $receiver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($header,$detail,$receiver)
    {
        $this->header = $header;
        $this->detail = $detail;
        $this->receiver = $receiver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $header = $this->header;
        $detail = $this->detail;
        $receiver = $this->receiver;
        return $this->view('ticketing/mail/requestUser',compact('header','detail','receiver'));
    }
}
