<?php

namespace App\Repository\Resignation\Status;

use App\Repository\Resignation\Status\Interfaces\StatusInterfaces;
use App\Model\Resignation\Resign;
use App\Model\Resignation\Feedback;
use Illuminate\Support\Facades\DB;

class StatusRepository implements StatusInterfaces
{
    public function geDataAllUnproceed($request)
    {
        $query =  Resign::with([
            'ApprovalMatrix',
            'Feedback',
            'User.Department',
        ]);

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
        $request->resign_status != null ? $query->where('resign_status', $request->resign_status) : $query->whereIn('resign_status', ['reject', 'cancel']);
        return $query->orderBy('resign_request_date','desc');
    }

    public function geDataAllProceed($request)
    {
        $query =  Resign::with([
            'ApprovalMatrix', 
            'Feedback', 
            'User.Department',
        ]);
        
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
        $request->resign_status != null ? $query->where('resign_status', $request->resign_status) : $query->whereIn('resign_status', ['in progress', 'approve']);
        return $query->orderBy('resign_request_date','desc');
    }

    public function cancelResign($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log("UPDATE", $request, "App\Model\Resignation\Resign");
            Resign::find($request->resign_id)->update($request->all());
        });
    }

    public function insertFeedback($request)
    {
        DB::transaction(function () use ($request) {
            Feedback::create($request->except('_token'));
            \Helper::instance()->log("CREATE", $request, "App\Model\Resignation\Feedback");
        });
    }

    public function DetailFeedbackPersonal($resign_id)
    {
        return Feedback::with(['Resign', 'Resign.User'])
            ->where('resign_id', $resign_id)
            ->first();
    }
}
