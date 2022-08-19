<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\AccessPositionService;

class AccessPositionController extends Controller
{
    private $AccessPositionService;

    public function __construct(AccessPositionService $AccessPositionService)
    {
        $this->AccessPositionService = $AccessPositionService;
    }

    public function show()
    {
        return $this->AccessPositionService->getData();
    }

    public function detail($id)
    {
        $data = $this->AccessPositionService->detailAccessPosition($id);
        return \Response::success(["data"=>$data]);
    }

    public function update(Request $request)
    {
        $this->AccessPositionService->updateAccessPosition($request);
        return \Response::success(["message"=>"Access Position Updated"]);
    }
}
