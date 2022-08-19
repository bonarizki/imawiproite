<?php

namespace App\Repository\Resignation\Approve;

use App\Repository\Resignation\Approve\Interfaces\ApproveInterfaces;
use App\Model\Resignation\Resign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApproveRepository implements ApproveInterfaces
{
    public function getData()
    {
        $user_nik = Auth::user()->user_nik;
        return Resign::with(['User.Department']) // get data resign dengan relasi user dan relasi department
            ->where('resign_status', 'in progress')
            // ->where('resign_status', '!=', 'cancel')
            ->where('resign_approval_nik_1', $user_nik)
            ->orWhere('resign_approval_nik_2', $user_nik)
            ->orWhere('resign_approval_nik_3', $user_nik)
            ->orWhere('resign_approval_nik_4', $user_nik)
            ->orWhere('resign_approval_nik_5', $user_nik)
            ->orWhere('resign_approval_nik_6', $user_nik)
            ->orWhere('resign_approval_nik_hr', $user_nik)
            ->orderBy('created_at','desc')
            ->get();
    }

    public function UpdateApproval($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log("UPDATE", $request, "App\Model\Resignation\Resign");
            Resign::find($request->resign_id)->update($request->except('_token'));
        });
    }

    public function getDetailResign($id)
    {
        return Resign::with([
            'User',
            'User.Grade',
            'User.Grade.GradeGroup', 
            'User.Department',
            'User.Title',
            'ResignApproval1',
            'ResignApproval2',
            'ResignApproval3',
            'ResignApproval4',
            'ResignApproval5',
            'ResignApproval6',
            'ResignApprovalhr',
        ])
            ->where('resign_id', $id)->first();
    }

    public function gedDataForClearance($request)
    {
        $query =  Resign::with(['User', 'User.Department']);
        if ($request->department_id != null) $query->whereHas('User.Department', function ($q) use ($request) {
            $q->where('department_id', 'like', '%' . $request->department_id . '%');
        });
        if ($request->user_nik != null) $query->whereHas('User', function ($q) use ($request) {
            $q->where('user_nik', 'like', '%' . $request->user_nik . '%');
        });
        if ($request->user_name != null) $query->whereHas('User', function ($q) use ($request) {
            $q->where('user_name', 'like', '%' . $request->user_name . '%');
        });
        if ($request->user_nik_auth != null) $query->where('user_nik', $request->user_nik_auth);
        $request->period_id == null ? $query->where('period_id', $request->period_id_now) :  $query->where('period_id', $request->period_id);
        $query->where('resign_status', 'approve');
        return $query->get();
    }
}
