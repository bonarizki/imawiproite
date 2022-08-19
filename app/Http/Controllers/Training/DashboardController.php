<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Training\DashboardService;

class DashboardController extends Controller
{
    private $DashboardService;

    public function __construct(DashboardService $DashboardService)
    {
        $this->DashboardService = $DashboardService;
    }
    
    /**
     * getAllData 
     *
     * @param  mixed $period_id paramater yang dikirimkan dari view (id period)
     * @return void
     */
    public function getAllData($period_id)
    {
        $data = $this->DashboardService->getAllData($period_id);
        return \Response::success(["data"=>$data]);
    }
    
    /**
     * feedbackParticipantNull mendapatkan data participant yang belum memberikan feedback
     *
     * @param  mixed $period_id paramater yang dikirimkan dari view (id period)
     * @return void
     */
    public function feedbackParticipantNull($period_id)
    {
        return $this->DashboardService->feedbackParticipantNull($period_id);
    }

    /**
     * feedbackParticipan mendapatkan data participant yang sudah memberikan feedback
     *
     * @param  mixed $period_id paramater yang dikirimkan dari view (id period)
     * @return void
     */
    public function feedbackParticipan($period_id)
    {
        return $this->DashboardService->feedbackParticipan($period_id);
    }

    public function remindParticipant(Request $request)
    {
        $data = $this->DashboardService->remindParticipant($request);
        return \Response::success(["message"=>$data]);
    }

}
