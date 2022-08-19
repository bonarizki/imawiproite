<?php

namespace App\Services\Resignation;

use App\Repository\Resignation\Resign\Interfaces\ResignInterfaces;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repository\Dashboard\Plugin\Interfaces\PluginPeriodInterfaces;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use App\Repository\Resignation\Approve\Interfaces\ApproveInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailResignation\ResignMail;
use Exception;

class ResignService
{
    private $ResignInterface;
    private $PluginPeriodInterfaces;
    private $HelperService;
    private $UserInterfaces;
    private $ApproveInterfaces;

    public function __construct(ResignInterfaces $ResignInterface, PluginPeriodInterfaces $PluginPeriodInterfaces, HelperService $HelperService, UserInterfaces $UserInterfaces, ApproveInterfaces $ApproveInterfaces)
    {
        $this->ResignInterface = $ResignInterface;
        $this->PluginPeriodInterfaces = $PluginPeriodInterfaces;
        $this->HelperService = $HelperService;
        $this->UserInterfaces = $UserInterfaces;
        $this->ApproveInterfaces = $ApproveInterfaces;
    }

    public function handleRequestResign($request)
    {
        $data = $this->checkUser($request);
        return $data;
    }

    public function checkUser($request)
    {
        $data = $this->ResignInterface->getUser($request);
        if ($data == null) {
            throw new ModelNotFoundException('Email User Not Found');
        } else {
            if ($data->password == $this->hashPass($request->password)) :
                $data = $this->ResignInterface->insertResign($this->makeArrayInsert($request));
                $mail['SendEmail'] = $this->UserInterfaces->getUserByNikGet([ // mendapatkan data user approval nik 1 dan approval hr untuk dikirimkan emaim
                    $data->resign_approval_nik_1,
                    $data->resign_approval_nik_hr
                ]);
                $mail['userResign'] = $this->ApproveInterfaces->getDetailResign($data->resign_id);
                return $mail;
            else :
                throw new ModelNotFoundException('User Email or User Password Not Valid');
            endif;
        }
    }

    public function hashPass($password)
    {
        return md5(sha1(md5('Hr' . $password . 'syst3m')));
    }

    public function makeArrayInsert($request)
    {
        $NewRequest = $request->only('user_nik');
        $data = $this->ResignInterface->DataApprovalMatrix($request->user_nik);
        if ($data == null) throw new ModelNotFoundException('Approval matrix has not been set');
        $NewRequest = array_merge([
            "resign_id" => $this->setUpId(),
            "created_by" => Auth::user()->user_name,
            "updated_by" => Auth::user()->user_name,
            "resign_request_date" => date('Y-m-d'),
            "period_id" => $this->HelperService->getIdPriodNow(),
            "resign_approval_nik_1" => Null,
            "resign_approval_nik_2" => Null,
            "resign_approval_nik_3" => Null,
            "resign_approval_nik_4" => Null,
            "resign_approval_nik_5" => Null,
            "resign_approval_nik_6" => Null,
            "resign_approval_nik_hr" => "45121101" ,
        ], $NewRequest);
        $NewRequest = $this->addApprovalNik($NewRequest, $data);
        return \Helper::instance()->MakeRequest($NewRequest);
    }

    public function addApprovalNik($NewRequest, $data)
    {
        $array = [
            "approval_nik_1",
            "approval_nik_2",
            "approval_nik_3",
            "approval_nik_4",
            "approval_nik_5",
            "approval_nik_6",
            "approval_nik_hr",
        ];

        foreach ($array as $key) {
            $NKey = 'resign_' . $key;
            if (isset($data->$key)) {
                $NewRequest[$NKey] = $data->$key;
            }
        }
        return $NewRequest;
    }

    public function setUpId()
    {
        $id = $this->ResignInterface->getLastId();
        if ($id == null) {
            $newID = sprintf("%03s", 1) . "/" . date("my") . "RSG";
        } else {
            $explode = explode("/", $id->resign_id);
            $newID = sprintf("%03s", $explode[0] + 1) . "/" . date("my") . "RSG";
        }
        return $newID;
    }

    public function sendMailResign($request)
    {

        try {
            \Mail::to(['address' => $request->recipient_email])
                ->cc([
                    'system.imawiproite@wipro-unza.co.id',
                    'atikah.djula@wipro-unza.co.id	',
                    'ardhini.retno@wipro-unza.co.id'
                ])
                ->send(new ResignMail($request));
        } catch (\Throwable $th) {
            throw new Exception("Failed To Send Email", 1);
        }
        return "email send";
    }
}
