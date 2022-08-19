<?php

namespace App\Http\Controllers\Resignation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Resignation\ApproveService;
use App\Helper\HelperService;

class ApproveController extends Controller
{
    private $ApproveService;
    private $HelperService;

    public function __construct(ApproveService $ApproveService,HelperService $HelperService)
    {
        $this->ApproveService = $ApproveService;
        $this->HelperService = $HelperService;
    }
    
    public function show()
    {
        $data = $this->ApproveService->GetDataForApprove();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function updateApproval(Request $request) // digunakan untuk melakukan update approval (approve dan reject)
    {
        $data = $this->ApproveService->UpdateApproval($request);
        $type = $request->type == 'reject' ? 'Reject' : 'Approve';
        return \Response::success([
            "message" => $type." Success",
            "data" => $data
        ]);
    }

    public function getDetailResign(Request $request)
    {
       $data = $this->ApproveService->getDetailResign($request->resign_id);
       return \Response::success(["data"=>$data]);
    }

    public function UpdateResign(Request $request) // digunakan untuk melakukan update data resign oleh hr
    {
        $this->ApproveService->updateResign($request);
        return \Response::success(["message"=>"Update Success"]);
    }
}
