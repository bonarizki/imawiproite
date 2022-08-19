<?php

namespace App\Services\Resignation;

use App\Helper\HelperService;
use App\Repository\Resignation\Status\Interfaces\StatusInterfaces;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use App\Repository\Resignation\Resign\Interfaces\ResignInterfaces;
use App\Repository\Resignation\Approve\Interfaces\ApproveInterfaces;
use App\Mail\MailResignation\ReminderFeedback;
use Illuminate\Support\Facades\Auth;

class StatusService
{
    private $StatusInterfaces;
    private $UserInterfaces;
    private $ResignInterfaces;
    private $HelperService;
    private $ApproveInterfaces;

    public function __construct(
        StatusInterfaces $StatusInterfaces, 
        UserInterfaces $UserInterfaces,
        ResignInterfaces $ResignInterfaces, 
        HelperService $HelperService,
        ApproveInterfaces $ApproveInterfaces)
    {
        $this->StatusInterfaces = $StatusInterfaces;
        $this->UserInterfaces = $UserInterfaces;
        $this->ResignInterfaces = $ResignInterfaces;
        $this->ApproveInterfaces = $ApproveInterfaces;
        $this->HelperService = $HelperService;
    }

    public function setPeriodNow($request)
    {
        $period_id_now = $this->HelperService->getIdPriodNow();
        return $request->merge([
            'period_id_now' => $period_id_now
        ]);
    }

    public function getDataResignByIdProceed($request) //data resign proceed user
    {
        $request = $this->setPeriodNow($request);
        $request->merge([
            'user_nik_auth' => Auth::user()->user_nik,

        ]);
        return $this->StatusInterfaces->geDataAllProceed($request);
    }

    public function geDataAllProceed($request) //data resign proceed admin
    {
        $request = $this->setPeriodNow($request);
        return $this->StatusInterfaces->geDataAllProceed($request);
    }

    public function geDataAllUnproceed($request) //data resign unproceed admin
    {
        $request = $this->setPeriodNow($request);
        return $this->StatusInterfaces->geDataAllUnproceed($request);
    }

    public function getDataResignByIdUnproceed($request) //data resign unproceed user
    {
        $request = $this->setPeriodNow($request);
        $request->merge([
            'user_nik_auth' => Auth::user()->user_nik,

        ]);
        return $this->StatusInterfaces->geDataAllUnproceed($request);
    }

    public function cancelResign($request)
    {
        $request->merge([
            "resign_status" => "cancel",
            "updated_by" => Auth::user()->user_name
        ]);
        return $this->StatusInterfaces->cancelResign($request);
    }

    public function insertFeedback($request)
    {
        $feedback_1 = implode("#", $request->resign_feedback_1);
        $request->request->remove("resign_feedback_1");
        $request->merge([
            "resign_feedback_1" => $feedback_1,
            "updated_by" => Auth::user()->user_name,
            "created_by" => Auth::user()->user_name
        ]);
        return $this->StatusInterfaces->insertFeedback($request);
    }

    public function getUserByDepartment()
    {
        return $this->UserInterfaces->getUserByDepartment(Auth::user()->department_id);
    }

    public function getUserAll($request)
    {
        return $this->UserInterfaces->getAllUser($request);
    }

    public function getUserByNik($user_nik)
    {
        return $this->UserInterfaces->getUserByNik($user_nik);
    }

    public function handoverResign($request)
    {
        $data = [
            "resign_handover_nik" => $request->user_handover_nik,
            "resign_handover_status" => $request->user_handover_status,
            "updated_by" => Auth::user()->user_name,
            "resign_id" => $request->resign_id
        ];
        $newRequest = \Helper::instance()->MakeRequest($data);
        return $this->ResignInterfaces->updateResign($newRequest);
    }

    public function remindFeedBack($resign_id)
    {
        //SET EMAIL PRIORITY
        $headers = "X-Priority: 1 (Highest)\n";
        $headers .= "X-MSMail-Priority: High\n";
        $headers .= "Importance: High\n";

        $id = str_replace("-", "/", $resign_id);
        $data = $this->ApproveInterfaces->getDetailResign($id);
        \Mail::to(['address' => $data->User->user_email])
        ->cc([
            'system.imawiproite@wipro-unza.co.id',
            // 'atikah.djula@wipro-unza.co.id'
        ])
        ->send(new ReminderFeedback($data));
    }
}
