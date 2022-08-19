<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Training\TrainingReportService;

class TrainingReportController extends Controller
{
    public function __construct(TrainingReportService $TrainingReportService)
    {
        $this->TrainingReportService = $TrainingReportService;
    }

    public function downloadRequest($training_id)
    {
        return $this->TrainingReportService->downloadRequest($training_id);
    }

    public function ViewReportTopic(Request $request)
    {
        $data = $this->TrainingReportService->ViewReportTopic($request);
        return \Response::success(["data" => $data]);
    }

    public function DownloadReportTopic(Request $request)
    {
        return $this->TrainingReportService->DownloadReportTopic($request);
    }

    public function ViewReportParticipant (Request $request)
    {
        $data = $this->TrainingReportService->ViewReportParticipant($request);
        return \Response::success(["data" => $data]);
    }

    public function DownloadReportParticipant(Request $request)
    {
        return $this->TrainingReportService->DownloadReportParticipant($request);
    }

    public function ViewReportMandays (Request $request)
    {
        $data = $this->TrainingReportService->ViewReportMandays($request);
        return \Response::success(["data" => $data]);
    }

    public function DownloadReportMandays(Request $request)
    {
        return $this->TrainingReportService->DownloadReportMandays($request);
    }

    public function ViewReportExpense (Request $request)
    {
        $data = $this->TrainingReportService->ViewReportExpense($request);
        return \Response::success(["data" => $data]);
    }

    public function DownloadReportExpense(Request $request)
    {
        return $this->TrainingReportService->DownloadReportExpense($request);
    }

    public function ViewReportExpenseLevel (Request $request)
    {
        $data = $this->TrainingReportService->ViewReportExpenseLevel($request);
        return \Response::success(["data" => $data]);
    }

    public function DownloadReportExpenseLevel(Request $request)
    {
        return $this->TrainingReportService->DownloadReportExpenseLevel($request);
    }

    public function ViewReportFeedback (Request $request)
    {
        $data = $this->TrainingReportService->ViewReportFeedback($request);
        return \Response::success(["data" => $data]);
    }

    public function DownloadReportFeedback(Request $request)
    {
        return $this->TrainingReportService->DownloadReportFeedback($request);
    }


}
