<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class MailPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = 'notification@wipro-unza.co.id';
        $subject = 'Change Password';
        $name = 'Notification';

        return $this->view('authorization.link',['user'=>$this->data])
                    ->from($address, $name)
                    ->subject($subject);
    }
}