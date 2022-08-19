<?php

namespace App\Repository\Training\Approval;

use App\Repository\Training\Approval\Interfaces\ApprovalInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Training\TrainingApproval;

class ApprovalRepository implements ApprovalInterfaces
{
    public static function getDataApproval($user_nik)
    {
        return TrainingApproval::with('Training')
            ->where('training_status','=','in_progress')
            ->where('training_approval_nik_1',$user_nik)
            ->whereNull('training_approval_nik_1_date')
            ->orWhere('training_approval_nik_2',$user_nik)
            ->whereNull('training_approval_nik_2_date')
            ->orWhere('training_approval_nik_3',$user_nik)
            ->whereNull('training_approval_nik_3_date')
            ->orWhere('training_approval_nik_4',$user_nik)
            ->whereNull('training_approval_nik_4_date')
            ->orWhere('training_approval_nik_5',$user_nik)
            ->whereNull('training_approval_nik_5_date')
            ->orWhere('training_approval_nik_6',$user_nik)
            ->whereNull('training_approval_nik_6_date')
            ->orWhere('training_approval_nik_hr',$user_nik)
            ->whereNull('training_approval_nik_hr_date')
            ->orWhere('training_approval_nik_ceo',$user_nik)
            ->whereNull('training_approval_nik_ceo_date')
            ->orderBy('training_id','desc');
    }

    public static function approveTraining($request)
    {
        $data = '';
        DB::transaction(function () use($request,&$data) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Training\TrainingApproval');
            TrainingApproval::find($request->training_approval_id)
                ->update($request->except('_token'));
            $data = TrainingApproval::find($request->training_approval_id);
        });
        return $data;
    }

    public static function getTrainingApproval($training_id)
    {
        return TrainingApproval::with('Training')
            ->where('training_id',$training_id)
            ->first();
    }

    public static function rejectTraining($request)
    {
        return DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Training\TrainingApproval');
            TrainingApproval::find($request->training_approval_id)
                ->update($request->except('_token'));
        });
    }

    public static function updateApproval($request)
    {
        return DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Training\TrainingApproval');
            TrainingApproval::find($request->training_approval_id)
                ->update($request->except('_token'));
        });
    }
}