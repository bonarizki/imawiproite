<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Dashboard\ModuleAdminService;
use App\Http\Requests\AdminModuleRequest;

class ModuleAdminController extends Controller
{
    private $ModuleAdminService;

    public function __construct(ModuleAdminService $ModuleAdminService)
    {
        $this->ModuleAdminService = $ModuleAdminService;
    }

    public function AdminByModule($id_module)
    {
        return $this->ModuleAdminService->AdminByModule($id_module);
    }

    public function create(AdminModuleRequest $request)
    {
        $this->ModuleAdminService->create($request);
        return \Response::success(["message"=>"Admin Added"]);
    }

    public function edit($admin_id)
    {
        $data = $this->ModuleAdminService->edit($admin_id);
        return \Response::success(["data"=>$data]);
    }

    public function update(AdminModuleRequest $request)
    {
        $this->ModuleAdminService->update($request);
        return \Response::success(["message"=>"Admin Updated"]);
    }

    public function delete(Request $request)
    {
        $this->ModuleAdminService->delete($request);
        return \Response::success(["message"=>"Admin Deleted"]);
    }
}
