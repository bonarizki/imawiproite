<?php

namespace App\Mail\MailRecruitment;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class RecruitmentMail extends Mailable
{
    use Queueable, SerializesModels;

    private $request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = (object) $this->request->all();

        return $this->view('recruitment/recruitment_email', compact('data'))->subject('Recruitment');
    }
}
