<?php

namespace App\Listeners\Training;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Training\SendMailEvent;
use App\Repository\Training\Request\Interfaces\TrainingRequestInterfaces as TrainingInterfaces;
use Exception;
use App\Mail\MailTraining\RequestTrainingMail as MailTraining;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;


class SendMailListener
{
    private $TrainingInterfaces,$UserInterfaces;
    /**
     * __construct Create the event listener
     *
     * @param  mixed $event
     * @return void
     */
    public function __construct(TrainingInterfaces $TrainingInterfaces,UserInterfaces $UserInterfaces)
    {
        $this->TrainingInterfaces = $TrainingInterfaces;
        $this->UserInterfaces = $UserInterfaces;
    }

    /**
     * Handle the event.
     *
     * @param  mixed $event
     * @return void
     */
    public function handle(SendMailEvent $event)
    {
        $data = $event->data;
        $participant = $this->TrainingInterfaces->getPartipantByIdTraining($data->training_id); // berisi data participan training
        $dataApproval = $this->TrainingInterfaces->GetApprovalRequest($data->training_id); // mendapatkan data approval training request beserta data user requester
        $approval_nik = $this->getApprovalNik($dataApproval); // mendapatkan nik user yang akan dikirimkan email
        $receiver = $this->UserInterfaces->getUserByNik($approval_nik); // mendapatkan data user approval by nik
        $object = (object) [
            "participant" => $participant,
            "receiver" => $receiver,
            "sender" => $dataApproval,
            "training" => $this->getDetailTraining($data->training_id)
        ];
        // try {
            \Mail::to(['address' => $receiver->user_email])
                ->cc([
                    'system.imawiproite@wipro-unza.co.id',
                    'viola.putri@wipro-unza.co.id'
                    // 'nurul.amaliyah@wipro-unza.co.id',
                    // 'ardhini.retno@wipro-unza.co.id'
                ])
                ->send(new MailTraining($object));
        // } catch (\Throwable $th) {
        //     throw new Exception("Can't Send Email");
        // }
    }

    public function getDetailTraining($training_id)
    {
        return $this->TrainingInterfaces->getDetailTraining($training_id);
    }

    public function getApprovalNik($data)
    {
        $user_nik_approval = '';
        for ($i=1; $i <=8 ; $i++) { 
            $training_approval = "training_approval_nik_";
            if ($i == 7 ) {
                $training_approval .= 'hr';
            }elseif ($i == 8 ) {
                $training_approval .= 'ceo';
            }else{
                $training_approval .= $i;
            }
            
            $training_approval_date = $training_approval.'_date';
            if ($data->$training_approval_date == null) {
                if ($data->$training_approval != null) {
                    $user_nik_approval = $data->$training_approval;
                    break;
                }
            }

            if($i == 8 && $user_nik_approval == ''){
                $user_nik_approval = $data->$training_approval;
            }
        }
        return $user_nik_approval;
    }
}
