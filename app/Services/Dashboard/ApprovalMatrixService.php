<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\ApprovalMatrix\Interfaces\ApprovalMatrixInterfaces;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class ApprovalMatrixService
{
    private $ApprovalMatrixInterfaces;

    public function __construct(ApprovalMatrixInterfaces $ApprovalMatrixInterfaces)
    {
        $this->ApprovalMatrixInterfaces = $ApprovalMatrixInterfaces;
    }
    public function getAllUserApproval()
    {
        $data = $this->ApprovalMatrixInterfaces->getAllUserApproval();
        return DataTables::of($data)
        ->editColumn('user_name',function($data){
            return $data->user_nik.' - '.$data->user_name;
        })
        ->editColumn('approval_name_1',function($data){
            return $data->approval_nik_1.' - '.$data->approval_name_1;
        })
        ->editColumn('approval_name_2',function($data){
            return $data->approval_nik_2.' - '.$data->approval_name_2;
        })
        ->editColumn('approval_name_3',function($data){
            return $data->approval_nik_3.' - '.$data->approval_name_3;
        })
        ->editColumn('approval_name_4',function($data){
            return $data->approval_nik_4.' - '.$data->approval_name_4;
        })
        ->editColumn('approval_name_5',function($data){
            return $data->approval_nik_5.' - '.$data->approval_name_5;
        })
        ->editColumn('approval_name_6',function($data){
            return $data->approval_nik_6.' - '.$data->approval_name_6;
        })
        ->editColumn('approval_name_ceo',function($data){
            return $data->approval_nik_ceo.' - '.$data->approval_name_ceo;
        })
        ->editColumn('approval_name_hr',function($data){
            return $data->approval_nik_hr.' - '.$data->approval_name_hr;
        })
        ->AddIndexColumn()
        ->make(true);
    }

    public function getDetailApprovalById($id)
    {
        return $this->ApprovalMatrixInterfaces->getDetailApprovalById($id);
    }

    public function updateApprovalUser($request)
    {
        $request->merge(["updated_by"=>Auth::user()->user_name]);
        return $this->ApprovalMatrixInterfaces->updateApprovalUser($request);
    }

    public function deleteApprovalUser($request)
    {
        return $this->ApprovalMatrixInterfaces->deleteApprovalUser($request);
    }

    public function insertApprovalUser($request)
    {
        $array = [
            "created_by"=>Auth::user()->user_name,
            "updated_by"=>Auth::user()->user_name,
            "approval_nik_ceo"=>"75101908",
            "approval_nik_hr"=>"45121101"
        ];
        $request->merge($array);
        $this->ApprovalMatrixInterfaces->insertApprovalUser($request);
    }
}