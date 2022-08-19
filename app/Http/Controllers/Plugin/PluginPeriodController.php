<?php

namespace App\Http\Controllers\Plugin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Plugins\PeriodRequest;
use App\Services\Dashboard\PluginService;

class PluginPeriodController extends Controller
{
    private $PluginService;

    public function __construct(PluginService $PluginService)
    {
        $this->PluginService = $PluginService;
    }
    public function getAllPluginPeriod(Request $request)
    {
        return $this->PluginService->getAllPluginPeriod($request);
        
    }

    public function getAllPluginPeriodActive()
    {
        return $this->PluginService->getAllPluginPeriodActive();
    }

    public function getPluginPeriodId($id)
    {
        $data = $this->PluginService->getPluginPeriodById($id);
        return response()->json(["status"=>"success","data"=>$data]);
    }

    public function updatePluginPeriodId(PeriodRequest $request) 
    {
        $this->PluginService->updatePluginPeriodById($request);
        return response()->json(["status"=>"success","message"=>"Period Updated"]);
    }

    public function insertPluginPeriod(PeriodRequest $request)
    {
        $this->PluginService->insertPluginPeriod($request);
        return response()->json(["status"=>"success","message"=>"Period Added"]);
    }

    public function deletePluginPeriod(Request $request)
    {
        $this->PluginService->deletePluginPeriod($request);
        return response()->json(["status"=>"success","message"=>"Period Deleted"]);
    }
}
