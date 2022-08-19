<?php

namespace App\Http\Controllers\Plugin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Plugins\YearRequest;
use App\Services\Dashboard\PluginService;

class PluginYearController extends Controller
{
    private $PluginService;

    public function __construct(PluginService $PluginService)
    {
        $this->PluginService = $PluginService;
    }
    public function getAllPluginYear(Request $request)
    {
        $data = $this->PluginService->getAllPluginYear($request);
        return $data ;
    }

    public function getAllPluginYearActive()
    {
        $data = $this->PluginService->getAllPluginYearActive();
        return $data;
    }

    public function getPluginYearId($id)
    {
        $data = $this->PluginService->getPluginYearById($id);
        return response()->json(["status"=>"success","data"=>$data]);
    }

    public function updatePluginYearId(YearRequest $request) 
    {
        $this->PluginService->updatePluginYear($request);
        return response()->json(["status"=>"success","message"=>"Year Updated"]);
    }

    public function insertPluginYear(YearRequest $request)
    {
        $this->PluginService->insertPluginYear($request);
        return response()->json(["status"=>"success","message"=>"Year Added"]);
    }

    public function deletePluginYear(Request $request)
    {
        $this->PluginService->deletePluginYear($request);
        
        return response()->json(["status"=>"success","message"=>"Year Deleted"]);
    }
}
