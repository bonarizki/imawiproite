<?php

namespace App\Mail\MailTraining;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestTrainingMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $participant = (object) $this->data->participant;
        $receiver = (object) $this->data->receiver;
        $sender = (object) $this->data->sender;
        $training = (object) $this->data->training;

        return $this->view('training/mail/RequestTraining',compact('participant','receiver','sender','training'))
        ->subject('Training');
    }
}
