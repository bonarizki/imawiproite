<?php

namespace App\Services\Resignation;

use App\Repository\Resignation\Approve\Interfaces\ApproveInterfaces;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;

class ApproveService
{
    private $ApproveInterfaces;
    private $HelperService;
    private $UserInterfaces;

    public function __construct(ApproveInterfaces $ApproveInterfaces, HelperService $HelperService, UserInterfaces $UserInterfaces)
    {
        $this->ApproveInterfaces = $ApproveInterfaces;
        $this->UserInterfaces = $UserInterfaces;
    }

    public function GetDataForApprove()
    {
        $data = $this->ApproveInterfaces->getData();
        return $data;
    }

    public function UpdateApproval($request) //update untuk atasan yang approval
    {
        //$request->index berguna untuk menunjukan index dari approval (approval1 - approval6)
        $data = [
            "resign_id" => $request->resign_id,
            "updated_by" => Auth::user()->user_name,
            "resign_approval_nik_" . $request->index . "_date" => date("Y-m-d h:i:s")
        ];
        if ($request->index == 'hr' && $request->type == 'approve') $data = array_merge($data, ["resign_status" => "$request->type"]);
        if ($request->type == 'reject') $data = array_merge($data, ["resign_status" => $request->type]);
        $newRequest = \Helper::instance()->MakeRequest($data);
        $this->ApproveInterfaces->UpdateApproval($newRequest);
        $mail = $this->DataForMail($request);
        return $mail;
    }

    public function DataForMail($request)
    {

        $data = $this->ApproveInterfaces->getDetailResign($request->resign_id);
        if ($request->index != 'hr') :
            $index = (int)$request->index + 1;
            $approval = 'resign_approval_nik_' . $index;
            $mail['SendEmail'] = $this->UserInterfaces->getUserByNik( // mendapatkan data user approval nik 1 dan approval hr untuk dikirimkan emaim
                $data->$approval
            );
            //jika sendemail null berarti dia approval atasan terakhir (raja terakhir)
            //jika raja terkahir maka akan mengirim email ke hr untuk approval
            if ($mail['SendEmail'] == null) :
                $mail['SendEmail'] = $this->UserInterfaces->getUserByNik('72031703'); //nik semenatar hr head kosong maka di ganti dengan dyndyn
            endif;
        else :
            $mail['SendEmail'] = null;
        endif;
        $mail['userResign'] = $this->ApproveInterfaces->getDetailResign($data->resign_id);
        return $mail;
    }

    public function getDetailResign($id)
    {
        return $this->ApproveInterfaces->getDetailResign($id);
    }

    public function updateResign($request)
    {
        $request->request->remove('user_name'); // parameter user_name dihapus karena tidak add di table resign
        return $this->ApproveInterfaces->UpdateApproval($request);
    }
}
