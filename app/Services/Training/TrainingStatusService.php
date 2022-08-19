<?php 

namespace App\Services\Training;

use App\Repository\Training\Status\Interfaces\TrainingStatusInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;

class TrainingStatusService {
    
    private $TrainingStatusInterfaces;
    private $HelperService;

    public function __construct(TrainingStatusInterfaces $TrainingStatusInterfaces,HelperService $HelperService)
    {
        $this->TrainingStatusInterfaces = $TrainingStatusInterfaces;
        $this->HelperService = $HelperService;
    }
    
    /**
     * TrainingAll semua data training berdasarkan period id dan tanpa training status
     *
     * @return void
     */
    public function TrainingAll($period_id)
    {
        $data = $this->TrainingStatusInterfaces->GetAllTraining($period_id);
        return $this->HelperService->DataTablesResponse($data);
    }
    
    /**
     * TrainingAllData semua data training dengan status in_progress dan approve
     *
     * @param  mixed $request
     * @return void
     */
    public function getTrainingAllData($request)
    {
        $data = $this->TrainingStatusInterfaces->GetTrainingProceed($request);
        return $this->HelperService->DataTablesResponse($data);
    }
    
    /**
     * TrainingDataById semua data training dengan status in_progress dan approve berdasarkan id user
     *
     * @param  mixed $request
     * @return void
     */
    public function getTrainingDataById($request){
        $request->merge([
            'user_nik_auth' => Auth::user()->user_nik
        ]);
        $data = $this->TrainingStatusInterfaces->GetTrainingProceed($request);
        return $this->HelperService->DataTablesResponse($data);

    }

    public function getTrainingStatusID($request)
    {
        return $this->TrainingStatusInterfaces->GetDetailTraining($request->training_id);
    }
    
    /**
     * TrainingAllDataUnproceed semua data training dengan status reject dan cancel
     *
     * @param  mixed $request
     * @return void
     */
    public function getTrainingAllDataUnproceed($request)
    {
        $data = $this->TrainingStatusInterfaces->GetTrainingUnproceed($request);
        return $this->HelperService->DataTablesResponse($data);
    }
    
    /**
     * TrainingDataByIdUnproceed semua data training dengan status reject dan cancel berdasarkan id user
     *
     * @param  mixed $request
     * @return void
     */
    public function getTrainingDataByIdUnproceed($request)
    {
        $request->merge([
            'user_nik_auth' => Auth::user()->user_nik
        ]);
        $data = $this->TrainingStatusInterfaces->GetTrainingUnproceed($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function CancelTraining($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        $request->merge([
            "training_status" => "cancel"
        ]);
        return $this->TrainingStatusInterfaces->CancelTraining($request);
    }
}