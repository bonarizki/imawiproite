<?php

namespace App\Repository\Training\Status;

use App\Repository\Training\Status\Interfaces\TrainingStatusInterfaces;
use App\Model\Training\Training;
use Illuminate\Support\Facades\DB;
use App\Model\Training\TrainingApproval;

class TrainingStatusRepository implements TrainingStatusInterfaces
{
    public static function GetTrainingProceed($request)
    {
        // dd($request->all());
        $query = Training::with([
            'TrainingApproval',
            'TrainingApproval.User',
            'TrainingApproval.User.Department',
            'Category'
        ]);

        if ($request->department_id != null) $query->whereHas('TrainingApproval.User.Department', function ($q) use($request) {
            $q->where('department_id',$request->department_id) ;
        });

        if($request->user_nik!=null) $query->whereHas('TrainingApproval.User', function ($q) use($request) {
            $q->where('user_nik','like','%'.$request->user_nik.'%') ;
        });

        if($request->user_name!=null) $query->whereHas('TrainingApproval.User', function ($q) use($request) {
            $q->where('user_name','like','%'.$request->user_name.'%') ;
        });

        if($request->training_status != null){
            $query->whereHas('TrainingApproval',function ($q) use($request) {
                $q->where('training_status',$request->training_status);
            });
        }else{
            $query->whereHas('TrainingApproval',function ($q) use($request) {
                $q->whereIN('training_status',['in_progress','approve']);
            });
        };

        if($request->user_nik_auth != null) $query->whereHas('TrainingApproval',function ($q) use($request) {
            $q->where('training_requester_nik',$request->user_nik_auth) ;
        });

        if($request->period_id != null) $query->where('period_id',$request->period_id);
        
        return $query->orderBy('training_id','desc')->get();
    }

    public static function GetDetailTraining($id)
    {
        return Training::with([
            'Vendor',
            'Participant',
            'TrainingApproval',
            'Participant.User',
            'Participant.User.Department',
            'Category',
            'Method'])
            ->where('training_id',$id)
            ->first();
    }

    public static function GetTrainingUnproceed($request)
    {
        $query = Training::with([
            'TrainingApproval',
            'TrainingApproval.User',
            'TrainingApproval.User.Department'
        ]);

        if ($request->department_id != null) $query->whereHas('TrainingApproval.User.Department', function ($q) use($request) {
            $q->where('department_id','like','%'.$request->department_id.'%') ;
        });

        if($request->user_nik!=null) $query->whereHas('TrainingApproval.User', function ($q) use($request) {
            $q->where('user_nik','like','%'.$request->user_nik.'%') ;
        });

        if($request->user_name!=null) $query->whereHas('TrainingApproval.User', function ($q) use($request) {
            $q->where('user_name','like','%'.$request->user_name.'%') ;
        });

        if($request->training_status != null){
            $query->whereHas('TrainingApproval',function ($q) use($request) {
                $q->where('training_status',$request->training_status);
            });
        }else{
            $query->whereHas('TrainingApproval',function ($q) use($request) {
                $q->whereIN('training_status',['cancel','reject']);
            });
        };

        if($request->user_nik_auth != null) $query->whereHas('TrainingApproval',function ($q) use($request) {
            $q->where('training_requester_nik',$request->user_nik_auth) ;
        });

        if($request->period_id != null) $query->where('period_id',$request->period_id);
        
        return $query->orderBy('training_id','desc')->get();
    }

    public static function CancelTraining($request)
    {
        return  DB::transaction(function () use($request) {
            TrainingApproval::where('training_id',$request->training_id)
                ->update($request->except('_token'));
            // \Helper::instance()->log('UPDATE',$request,'App\Model\Training\TrainingApproval');
            // DB::transaction(function () use ($request) {
            //     // \Helper::instance()->log('DELETE',$request,'App\Model\Training\TrainingApproval');
            //     TrainingApproval::where('training_id',$request->training_id)
            //         ->delete();
            // });
        });
    }

    public static function GetAllTraining($period_id)
    {
        return Training::with([
            'TrainingApproval',
            'TrainingApproval.User',
            'TrainingApproval.User.Department',
            'Category'
        ])->where('period_id',$period_id)
        ->get();
    }
}