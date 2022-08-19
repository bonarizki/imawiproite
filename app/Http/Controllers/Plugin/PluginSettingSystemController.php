<?php

namespace App\Http\Controllers\Plugin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Plugins\SettingRequest;
use App\Services\Dashboard\PluginService;

class PluginSettingSystemController extends Controller
{
    private $PluginService;

    public function __construct(PluginService $PluginService)
    {
        $this->PluginService = $PluginService;
    }

    public function getAllSystemSetting(Request $request)
    {
        return $this->PluginService->getAllSystemSetting($request);
    }

    public function getPluginSystemSettingId($id)
    {
        $data = $this->PluginService->getPluginSystemSettingById($id);
        return response()->json(["status"=>"success","data"=>$data]);
    }

    public function updatePluginSystemSettingId(SettingRequest $request) 
    {
        $this->PluginService->updatePluginSystemSettingById($request);
        return response()->json(["status"=>"success","message"=>"System Setting Updated"]);
    }

    public function insertPluginSystemSetting(SettingRequest $request)
    {
        $this->PluginService->insertPluginSystemSetting($request);
        return response()->json(["status"=>"success","message"=>"System Setting Added"]);
    }

    public function deletePluginSystemSetting(Request $request)
    {
        $this->PluginService->deletePluginSystemSetting($request);
        return response()->json(["status"=>"success","message"=>"System Setting Deleted"]);
    }
}
