<?php

namespace App\Listeners\Ticketing;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Ticketing\SendMailRequestUser AS SendMailEvent;
use App\Mail\MailTicketing\SendMailRequestUser As MailRequestuser;
use App\Repository\Ticketing\RequestTicketing\Interfaces\RequestTicketingInterfaces;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use Exception;

class SendMailRequestuser
{
    public $RequestTicketingInterfaces;
    public $UserInterfaces;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(RequestTicketingInterfaces $RequestTicketingInterfaces,UserInterfaces $UserInterfaces)
    {
        $this->RequestTicketingInterfaces = $RequestTicketingInterfaces;
        $this->UserInterfaces = $UserInterfaces;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SendMailEvent $event)
    {
        $header = $event->header->load('RequestBy');
        $detail = $event->detail;
        $user_nik = $event->user_nik;

        $dataApproval = $this->RequestTicketingInterfaces->GetApprovalRequest($header->ticket_id); // mendapatkan data approval ticketing
        
        
        $approval_nik = $this->getApprovalNik($dataApproval); // mendapatkan nik user yang akan dikirimkan email
        if ($approval_nik != null) {
            $receiver = $this->UserInterfaces->getUserByNik($approval_nik); // mendapatkan data user approval by nik
            try {
                \Mail::to(['address' => $receiver->user_email])
                    ->cc([
                        'system.imawiproite@wipro-unza.co.id',
                    ])
                    ->send(new MailRequestuser($header,$detail,$receiver));
            } catch (\Throwable $th) {
                throw new Exception("Can't Send Email");
            }
        }
        

    }

    public function getApprovalNik($data)
    {
        $user_nik_approval = '';
        for ($i=1; $i <=8 ; $i++) { 
            $ticketing_approval = "ticketing_approval_nik_";
            if ($i == 7 ) {
                $ticketing_approval .= 'it1';
            }elseif ($i == 8 ) {
                $ticketing_approval .= 'it2';
            }else{
                $ticketing_approval .= $i;
            }
            
            $ticketing_approval_date = $ticketing_approval.'_date';

            if ($data->$ticketing_approval != null) {
                if ($data->$ticketing_approval_date == null) {
                    $user_nik_approval = $data->$ticketing_approval;
                    break;
                }
            }

        }
        return $user_nik_approval;
    }
}
