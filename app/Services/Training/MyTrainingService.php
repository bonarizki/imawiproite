<?php

namespace App\Services\Training;

use App\Helper\HelperService;
use App\Repository\Training\MyTraining\Interfaces\MyTrainingInterfaces;
use Illuminate\Support\Facades\Auth;


class MyTrainingService 
{
    private $MyTrainingInterfaces;
    private $HelperService;

    public function __construct(MyTrainingInterfaces $MyTrainingInterfaces,HelperService $HelperService)
    {
        $this->MyTrainingInterfaces = $MyTrainingInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getMyTraining()
    {
        $data = $this->MyTrainingInterfaces->getMyTraining(Auth::user()->user_nik);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getDetailParticipant($training_id)
    {
        $training_id = str_replace('-','/',$training_id);
        return $this->MyTrainingInterfaces->getDetailParticipant($training_id,Auth::user()->user_nik);
    }

    public function insertFeedback($request)
    {
        return $this->MyTrainingInterfaces->insertFeedback($request);
    }
}