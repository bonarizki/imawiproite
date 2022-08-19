<?php

namespace App\Repository\Dashboard\ApprovalMatrix;

use App\Repository\Dashboard\ApprovalMatrix\Interfaces\ApprovalMatrixInterfaces;
use App\Model\ApprovalMatrix;
use Illuminate\Support\Facades\DB;

class ApprovalMatrixRepository implements ApprovalMatrixInterfaces
{
    public function getAllUserApproval()
    {
        return ApprovalMatrix::GetData();
    }

    public function getDetailApprovalById($id)
    {
        return ApprovalMatrix::find($id);
    }

    public function updateApprovalUser($request)
    {
        DB::transaction(function () use ($request){
            \Helper::instance()->log('UPDATE',$request,'App\Model\ApprovalMatrix');
            ApprovalMatrix::find($request->approval_id)
                            ->update($request->except('_token'));
        });
    }

    public function deleteApprovalUser($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\ApprovalMatrix');
            ApprovalMatrix::find($request->approval_id)
                            ->delete();
        });
    }

    public function insertApprovalUser($request)
    {
        DB::transaction(function () use($request) {
            ApprovalMatrix::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\ApprovalMatrix');
        });
    }

    public function getApprovalByNik($nik)
    {
        return ApprovalMatrix::where("user_nik",$nik)->first();
    }
}