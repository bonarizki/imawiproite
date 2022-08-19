<?php

namespace App\Repository\Training\Request;

use App\Repository\Training\Request\Interfaces\TrainingRequestInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Training\Training;
use App\Model\Training\TrainingParticipants as Participants;
use App\Model\Training\TrainingApproval;

class TrainingRequestRepository implements TrainingRequestInterfaces
{
    public static function getLastId()
    {
        return Training::select('training_id')
            ->latest()
            ->first();
    }

    public static function CreateRequest($request)
    {
        $data = null;
        DB::transaction(function () use ($request, &$data) {
            $data = Training::create($request->toArray());
            $data = \Helper::instance()->makeRequest($data->toArray());
            \Helper::instance()->log('CREATE', $data, 'App\Model\Training\Training');
        });
        return $data;
    }

    public static function CreateParticipant($participant)
    {
        return DB::transaction(function () use ($participant) {
            for ($i = 0; $i < count($participant); $i++) {
                $data = Participants::create($participant[$i]);
                $data = \Helper::instance()->makeRequest($data->toArray());
                \Helper::instance()->log('CREATE', $data, 'App\Model\Training\TrainingParticipants');
            }
        });
    }

    public static function insertUpdateApproval($data)
    {
        return DB::transaction(function () use ($data) {
            $data = \Helper::instance()->makeRequest($data);
            if (TrainingApproval::where('training_id', $data->training_id)->exists()) {
                $dataOld = TrainingApproval::where('training_id', $data->training_id)->first();
                $data = $data->merge([
                    "training_approval_id" => $dataOld->training_approval_id
                ]);
                \Helper::instance()->log('UPDATE', $data, 'App\Model\Training\TrainingApproval');
                $data = TrainingApproval::where('training_id', $data->training_id)
                    ->update($data->except(['_token']));
            } else {
                TrainingApproval::create($data->toArray());
                $data = $data->merge([
                    "training_approval_id" => $data->training_approval_id
                ]);
                \Helper::instance()->log('CREATE', $data, 'App\Model\Training\TrainingApproval');
            }

        });
    }

    public static function getPartipantByIdTraining($training_id)
    {
        return Participants::with(['User', 'User.Department'])
            ->where('training_id', $training_id)->get();
    }

    public static function GetApprovalRequest($training_id)
    {
        return TrainingApproval::with('User')
            ->where('training_id', $training_id)
            ->first();
    }

    public static function getDetailTraining($training_id)
    {
        return Training::with(['Vendor', 'TrainingApproval'])
            ->where('training_id', $training_id)
            ->first();
    }

    public static function update($request)
    {
        return DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\Training\Training');
            Training::find($request->training_id)
                ->update($request->except(['_token', 'participant_name']));
        });
    }

    public static function deleteTrainingParticipant($id)
    {
        return DB::transaction(function () use ($id) {
            Participants::where('training_id', $id)
                ->forceDelete();
        });
    }

    public static function insertParticipant($request)
    {
        return DB::transaction(function () use ($request) {
            $data = Participants::create($request->toArray());
            $request->merge([
                "training_participant_id" => $data->training_participant_id
            ]);
            \Helper::instance()->log('CREATE', $request, 'App\Model\Training\TrainingParticipants');
        });
    }
}
