<?php

namespace App\Http\Controllers\Resignation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Resignation\ClearanceService;
use App\Http\Requests\Resignation\ClearanceRequest;
use App\Repository\Resignation\Approve\Interfaces\ApproveInterfaces;
use App\Helper\Response;

class ClearanceController extends Controller
{
    private $ClearanceService;

    public function __construct(ClearanceService $ClearanceService)
    {
        $this->ClearanceService = $ClearanceService;
    }
    public function show()
    {
        return $this->ClearanceService->getQuestionClearance();
    }

    public function store(ClearanceRequest $request)
    {
        $this->ClearanceService->insertClearanceQuestion($request);
        return Response::success(["message"=>"Insert Question Success"]);
    }

    public function detail($id)
    {
        $data = $this->ClearanceService->DetailClearanceQuestion($id);
        return Response::success($data);
    }

    public function update(ClearanceRequest $request)
    {
        $this->ClearanceService->updateClearanceQuestion($request);
        return Response::success(["message"=>"Update Question Success"]);
    }

    public function delete(Request $request)
    {
        $this->ClearanceService->deleteClearanceQuestion($request);
        return Response::success(["message"=>"Delete Question Success"]);
    }

    public function GetData(Request $request)
    {
        return $this->ClearanceService->getDataApprovalClearance($request);
    }

    public function storeAnswer(Request $request)
    {
        $this->ClearanceService->insertOrUpdateAnswer($request);
        return Response::success(["message"=>"Save Success"]);
    }

    public function showAnswer(Request $request)
    {
        $data = $this->ClearanceService->getAnswer($request->resign_id);
        return Response::success(["message"=>"success","data"=>$data]);
    }
}
