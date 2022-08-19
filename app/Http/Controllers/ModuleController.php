<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ModuleRequest;
use App\Services\Dashboard\ModuleService;

class ModuleController extends Controller
{

    private $ModuleService;

    public function __construct(ModuleService $ModuleService)
    {
        $this->ModuleService = $ModuleService;
    }
    public function index()
    {
        return view('module');
    }

    public function AllModule()
    {
        $data = $this->ModuleService->getAllModule();
        return $data;
    }

    public function getModuleById($id)
    {
        $data = $this->ModuleService->getModuleById($id);
        return response()->json(["statu" => "success", "data" => $data]);
    }

    public function updateModule(ModuleRequest $request) 
    {
        $this->ModuleService->updateModule($request);
        return response()->json(["status" => "success", "message" => "Module Updated"]);
    }

    public function insertModule(ModuleRequest $request)
    {
        $this->ModuleService->insertModule($request);
        return response()->json(["status"=>"success","message"=>"Module Added"]);
    }
    
    public function deleteModule(Request $request)
    {
        $this->ModuleService->deleteModule($request);
        return response()->json(["status"=>"success","message"=>"Module Deleted"]);
    }

    public function getModuleAccess(Request $request)
    {
        $data = $this->ModuleService->getModuleAccess();
        return response()->json($data);
    }
}
