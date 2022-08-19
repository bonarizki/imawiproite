<?php

namespace App\Repository\Training\MyTraining;

use App\Repository\Training\MyTraining\Interfaces\MyTrainingInterfaces;
use App\Model\Training\Training;
use App\Model\Training\TrainingParticipants;
use App\Model\Training\Feedback;
use Illuminate\Support\Facades\DB;

class MyTrainingRepository implements MyTrainingInterfaces
{
    public static function getMyTraining($user_nik)
    {
        return TrainingParticipants::with([
            'Training',
            'Feedback',
            'Training.TrainingApproval',
        ])
        ->whereHas('Training.TrainingApproval',function($q){
            $q->where('training_status','approve');
        })
        ->where('training_user_nik',$user_nik)
        ->get();

    }

    public static function getDetailParticipant($training_id,$user_nik)
    {
        return TrainingParticipants::where("training_user_nik",$user_nik)
            ->where("training_id",$training_id)
            ->first();
    }

    public static function insertFeedback($request)
    {
        return DB::transaction(function () use($request) {
            $data = Feedback::create($request->except('_token'));
            $newRequest = \Helper::instance()->makeRequest($data->toArray());
            \Helper::instance()->log('CREATE',$newRequest,'App\Model\Training\Feedback');
        });
    }
}
