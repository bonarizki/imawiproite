<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Training\TrainingRequestService as RequestService;
use App\Http\Requests\Training\TrainingRequest;

class TrainingRequestController extends Controller
{
    private $RequestService;

    public function __construct(RequestService $RequestService)
    {
        $this->RequestService = $RequestService;
    }

    public function getParticipant()
    {
        return $this->RequestService->getParticipant();
    }

    public function getParticipantAll(Request $request)
    {
        return $this->RequestService->getParticipantAll($request);
    }

    public function create(TrainingRequest $request)
    {
        $this->RequestService->createRequest($request);
        return \Response::success(["status"=>"success","message" => "Training Request Created"]);
    }

    public function update(TrainingRequest $request)
    {
        $this->RequestService->update($request);
        return \Response::success(["status"=>"success","message" => "Training Request Updated"]);
    }

    public function validateParticipantTraining(Request $request)
    {
        return $this->RequestService->uploadParticipant($request);
    }
}
