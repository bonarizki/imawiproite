<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Training\TrainingStatusService;

class TrainingStatusController extends Controller
{
    private $TrainingStatusService;

    public function __construct(TrainingStatusService $TrainingStatusService)
    {
        $this->TrainingStatusService = $TrainingStatusService;
    }
    
    /**
     * TrainingAll semua data training berdasarkan period id dan tanpa training status
     *
     * @return void
     */
    public function TrainingAll($period_id)
    {
        return $this->TrainingStatusService->TrainingAll($period_id);
    }
    
    /**
     * TrainingAllData semua data training dengan status in_progress dan approve
     *
     * @param  mixed $request
     * @return void
     */
    public function TrainingAllData(Request $request)
    {
        return $this->TrainingStatusService->getTrainingAllData($request);
    }
    
    /**
     * TrainingDataById semua data training dengan status in_progress dan approve berdasarkan id user
     *
     * @param  mixed $request
     * @return void
     */
    public function TrainingDataById(Request $request)
    {
        return $this->TrainingStatusService->getTrainingDataById($request);
    }

    public function DetailTraining(Request $request)
    {
        $data = $this->TrainingStatusService->getTrainingStatusID($request);
        return \Response::success($data);
    }
    
    /**
     * TrainingAllDataUnproceed semua data training dengan status reject dan cancel
     *
     * @param  mixed $request
     * @return void
     */
    public function TrainingAllDataUnproceed(Request $request)
    {
        return $this->TrainingStatusService->getTrainingAllDataUnproceed($request);
    }
    
    /**
     * TrainingDataByIdUnproceed semua data training dengan status reject dan cancel berdasarkan id user
     *
     * @param  mixed $request
     * @return void
     */
    public function TrainingDataByIdUnproceed(Request $request)
    {
        return $this->TrainingStatusService->getTrainingDataByIdUnproceed($request);
    }

    public function CancelTraining(Request $request)
    {
        $this->TrainingStatusService->CancelTraining($request);
        return \Response::success(["message"=>"Training Request Cancel"]);
    }
}
