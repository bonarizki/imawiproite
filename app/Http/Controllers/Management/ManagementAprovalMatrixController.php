<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApprovalRequest;
use App\Services\Dashboard\ApprovalMatrixService;

class ManagementAprovalMatrixController extends Controller
{
    private $ApprovalMatrixService;
    
    public function __construct(ApprovalMatrixService $ApprovalMatrixService)
    {
        $this->ApprovalMatrixService = $ApprovalMatrixService;
    }
    public function index()
    {
        return view('management/aprovalMatrix');
    }

    public function AllApproval()
    {
        return $this->ApprovalMatrixService->getAllUserApproval();
    }

    public function getApprovalById($id)
    {
        $data = $this->ApprovalMatrixService->getDetailApprovalById($id);
        return response()->json(["statu"=>"success","data"=>$data]);
    }

    public function updateApproval(ApprovalRequest $request)
    {
        $this->ApprovalMatrixService->updateApprovalUser($request);
        return response()->json(["status"=>"success","message"=>"Approval Updated"]);
    }

    public function deleteApproval(Request $request)
    {
        $this->ApprovalMatrixService->deleteApprovalUser($request);
        return response()->json(["status"=>"success","message"=>"Approval Deleted"]);
    }

    public function insertApproval(ApprovalRequest $request){
        $this->ApprovalMatrixService->insertApprovalUser($request);
        return response()->json(["status"=>"success","message"=>"Approval Added"]);
    }
}
