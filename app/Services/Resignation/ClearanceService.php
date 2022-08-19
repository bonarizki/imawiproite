<?php

namespace App\Services\Resignation;

use App\Repository\Resignation\Clearance\Interfaces\ClearanceInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;
use App\Repository\Resignation\Approve\Interfaces\ApproveInterfaces;
use Illuminate\Support\Facades\DB;


class ClearanceService
{
    private $ClearanceInterfaces, $HelperService;

    public function __construct(ClearanceInterfaces $ClearanceInterfaces, HelperService $HelperService, ApproveInterfaces $ApproveInterfaces)
    {
        $this->ClearanceInterfaces = $ClearanceInterfaces;
        $this->HelperService = $HelperService;
        $this->ApproveInterfaces = $ApproveInterfaces;
    }

    public function getQuestionClearance()
    {
        $data = $this->ClearanceInterfaces->getQuestionClearance();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function insertClearanceQuestion($request)
    {
        $request->merge([
            "created_by" => Auth::user()->user_name,
            "updated_by" => Auth::user()->user_name,
        ]);
        return $this->ClearanceInterfaces->insertClearanceQuestion($request);
    }

    public function DetailClearanceQuestion($id)
    {
        return $this->ClearanceInterfaces->DetailClearanceQuestion($id);
    }

    public function updateClearanceQuestion($request)
    {
        return $this->ClearanceInterfaces->updateClearanceQuestion($request);
    }

    public function deleteClearanceQuestion($request)
    {
        return $this->ClearanceInterfaces->deleteClearanceQuestion($request);
    }

    public function getDataApprovalClearance($request)
    {
        $request->merge([
            'period_id_now' => $this->HelperService->getIdPriodNow()
        ]);
        $data = $this->ApproveInterfaces->gedDataForClearance($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function insertOrUpdateAnswer($request)
    {
        $request->merge([
            "created_by" => Auth::user()->user_name,
            "updated_by" => Auth::user()->user_name,
        ]);
        DB::transaction(function () use ($request) {
            $this->ClearanceInterfaces->insertOrUpdateAnswer($request); // proses insert atau update
            $this->updateApprovalClearance($request); // update approval clearance di table resign list
            $this->updateApprovalStatusClearance($request); //melakukan pengencekan dan update apakah semua clearance sudah di isi
        });
        return true;
    }

    public function getAnswer($resign_id)
    {
        return $this->ClearanceInterfaces->getAnswer($resign_id);
    }

    public function updateApprovalClearance($request)
    {
        $department_id = Auth::user()->department_id;

        //proses menentukan field yang mana yang akan di isi berdarakan departmentnya
        if ($department_id == "3") {
            $field_name = "resign_approval_nik_clearance_it";
        } elseif ($department_id == "2") {
            $field_name = "resign_approval_nik_clearance_hr";
        } elseif ($department_id == "1") {
            $field_name = "resign_approval_nik_clearance_fa";
        }
        //end

        $array = [
            "resign_id" => $request->resign_id,
            $field_name => Auth::user()->user_nik,
            $field_name . "_date" => date("Y-m-d h:i:s"),
            "updated_by" => Auth::user()->user_name,
        ];
        $newRequest = \Helper::instance()->MakeRequest($array); // merubah array menjadi sebuah request
        return $this->ApproveInterfaces->UpdateApproval($newRequest);
    }

    public function updateApprovalStatusClearance($request)
    {
        $data = $this->ApproveInterfaces->getDetailResign($request->resign_id);
        // untuk mengupdate approval status approval clearance tidak boleh null
        if (($data->resign_approval_nik_clearance_it != null) && ($data->resign_approval_nik_clearance_hr != null) && ($data->resign_approval_nik_clearance_fa != null)) {
            $array = [
                "resign_id" => $request->resign_id,
                "resign_clearance_status" => "approve",
                "updated_by" => Auth::user()->user_name,
            ];
            $newRequest = \Helper::instance()->MakeRequest($array); // merubah array menjadi sebuah request
            $this->ApproveInterfaces->UpdateApproval($newRequest);
        }

        return true;
    }
}
