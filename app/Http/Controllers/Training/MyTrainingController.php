<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Training\MyTrainingService;

class MyTrainingController extends Controller
{
    private $MyTrainingService;

    public function __construct(MyTrainingService $MyTrainingService)
    {
        $this->MyTrainingService = $MyTrainingService;
    }

    public function myTraining()
    {
        return $this->MyTrainingService->getMyTraining();
    }

    public function getDetailParticipant($training_id)
    {
        $data = $this->MyTrainingService->getDetailParticipant($training_id);
        return \Response::success(["data"=>$data]);
    }

    public function insFeedbackTraining(Request $request)
    {
        $this->MyTrainingService->insertFeedback($request);
        return \Response::success(["status"=>"success","message" => "Feedback Added"]);
    }
}
