<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\ModuleAdmin\Interfaces\ModuleAdminInterfaces;
use App\Helper\HelperService;

class ModuleAdminService {
    
    private $ModuleAdminInterfaces;
    private $HelperService;

    public function __construct(ModuleAdminInterfaces $ModuleAdminInterfaces,HelperService $HelperService)
    {
        $this->ModuleAdminInterfaces = $ModuleAdminInterfaces;
        $this->HelperService = $HelperService;
    }

    public function AdminByModule($id_module)
    {
        $data = $this->ModuleAdminInterfaces->getAdminByModuleId($id_module);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function create($request)
    {
        $request = $this->HelperService->addAuthInsert($request);
        return $this->ModuleAdminInterfaces->create($request);
    }

    public function edit($admin_id)
    {
        return $this->ModuleAdminInterfaces->edit($admin_id);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->ModuleAdminInterfaces->update($request);
    }

    public function delete($request)
    {
        return $this->ModuleAdminInterfaces->delete($request);
    }
}