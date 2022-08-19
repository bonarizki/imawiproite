<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Training\ApprovalService;

class TrainingApprovalController extends Controller
{
    private $ApprovalService;

    public function __construct(ApprovalService $ApprovalService)
    {
        $this->ApprovalService = $ApprovalService;
    }

    public function getDataApproval()
    {
        return $this->ApprovalService->getDataApproval();
    }

    public function approveTraining(Request $request)
    {
        $this->ApprovalService->approveTraining($request);
        return \Response::success(["status"=>"success","message" => "Training Request Approve"]);
    }

    public function rejectTraining(Request $request)
    {
        $this->ApprovalService->rejectTraining($request);
        return \Response::success(["status"=>"success","message" => "Training Request Reject"]);
    }
}
