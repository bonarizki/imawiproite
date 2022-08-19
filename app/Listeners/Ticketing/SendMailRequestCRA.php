<?php

namespace App\Listeners\Ticketing;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Ticketing\SendMailRequestCRA AS SendMailEvent;
use App\Mail\MailTicketing\MailRequestCRA as MailRequestCRA;
use App\Repository\Ticketing\RequestTicketing\Interfaces\RequestTicketingInterfaces;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use Exception;

class SendMailRequestCRA
{
    /**
     * Create the event listener.
     *
     * @return void
     */
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
                    ->send(new MailRequestCRA($header,$detail,$receiver));
            } catch (\Throwable $th) {
                throw new Exception("Can't Send Email");
            }
        }
        

    }

    public function getApprovalNik($data)
    {
        $user_nik_approval = '';

        if ($data->ticketing_approval_nik_it2_date == null) { //jika approval date dari it2 null maka kirim email
            $user_nik_approval = $data->ticketing_approval_nik_it2;
        }else{
            for ($i=1; $i <=6 ; $i++) { 
                $ticketing_approval = "ticketing_approval_nik_" . $i ;
                
                $ticketing_approval_date = $ticketing_approval.'_date';
                if ($data->$ticketing_approval != null) {
                    if ($data->$ticketing_approval_date == null) {
                        $user_nik_approval = $data->$ticketing_approval;
                        break;
                    }
                }
    
            }
        }

        return $user_nik_approval;
    }
}
