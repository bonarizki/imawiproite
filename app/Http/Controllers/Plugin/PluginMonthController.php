<?php

namespace App\Http\Controllers\Plugin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Plugins\MonthRequest;
use App\Services\Dashboard\PluginService;

class PluginMonthController extends Controller
{
    private $PluginService;

    public function __construct(PluginService $PluginService)
    {
        $this->PluginService = $PluginService;
    }
    public function getAllPluginMonth(Request $request)
    {
        return $this->PluginService->getAllPluginMonth($request);
    }

    public function getPluginMonthId($id)
    {
        $data = $this->PluginService->getPluginMonthById($id);
        return response()->json(["status"=>"success","data"=>$data]);
    }

    public function updatePluginMonthId(MonthRequest $request) 
    {
        $this->PluginService->updatePluginMonthId($request);
        return response()->json(["status"=>"success","message"=>"Month Updated"]);
    }

    public function insertPluginMonth(MonthRequest $request)
    {
        $this->PluginService->insertPluginMonth($request);
        return response()->json(["status"=>"success","message"=>"Month Added"]);
    }

    public function deletePluginMonth(Request $request)
    {
        $this->PluginService->deletePluginMonth($request);
        return response()->json(["status"=>"success","message"=>"Month Deleted"]);
    }
}
