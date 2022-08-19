<?php

namespace App\Http\Controllers\Plugin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Plugins\VersionRequest;
use App\Services\Dashboard\PluginService;
class PluginVersionController extends Controller
{
    private $PluginService;
    
    public function __construct(PluginService $PluginService)
    {
        $this->PluginService = $PluginService;
    }
    public function getAllPluginVersion(Request $request)
    {
        return $this->PluginService->getAllPluginVersion($request);
    }

    public function getPluginVersionId($id)
    {
        $data = $this->PluginService->getPluginVersionId($id);
        return response()->json(["status"=>"success","data"=>$data]);
    }

    public function updatePluginVersionId(VersionRequest $request)
    {
        $this->PluginService->updatePluginVersionId($request);
        return response()->json(["status"=>"success","message"=>"Version Updated"]);
    }

    public function insertPluginVersion(VersionRequest $request)
    {
        $this->PluginService->insertPluginVersion($request);
        return response()->json(["status"=>"success","message"=>"Version Added"]);
    }

    public function deletePluginVersion(Request $request)
    {
        $this->PluginService->deletePluginVersion($request);
        
        
        return response()->json(["status"=>"success","message"=>"Version Deleted"]);
    }
}
