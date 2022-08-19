<?php

namespace App\Http\Controllers\Resignation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ResignRequest;
use App\Services\Resignation\ResignService;

class ResignController extends Controller
{
    private $ResignService;

    public function __construct(ResignService $ResignService)
    {
        $this->ResignService = $ResignService;
    }

    public function store(ResignRequest $request)
    {
        $data = $this->ResignService->handleRequestResign($request);
        return response()->json([
            "status" => "success", 
            "message" => "Submission of resignation has been accepted",
            "data" => $data
        ]);
    }

    public function sendMailResign(Request $request)
    {
        $data = (object) $this->ResignService->sendMailResign($request);
        return \Response::success(["data"=>$data]);
    }
}
