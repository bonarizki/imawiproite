<?php

namespace App\Services\Ticketing;

use App\Repository\Ticketing\SystemApplications\Interfaces\SystemApplicationsInterfaces;
use App\Helper\HelperService;

class SystemApplicationService
{
    public $SystemApplicationsInterfaces;

    public function __construct(SystemApplicationsInterfaces $SystemApplicationsInterfaces, HelperService $HelperService)
    {
        $this->SystemApplicationsInterfaces = $SystemApplicationsInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getData()
    {
        $data = $this->SystemApplicationsInterfaces->getAllData();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function store($request)
    {
       $this->HelperService->addAuthInsert($request);
       return $this->SystemApplicationsInterfaces->insert($request);
    }

    public function edit($id)
    {
        return $this->SystemApplicationsInterfaces->edit($id);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->SystemApplicationsInterfaces->update($request);
    }

    public function destroy($id)
    {
        $request = \Helper::instance()->MakeRequest(["system_id"=>$id]);
        return $this->SystemApplicationsInterfaces->destroy($request);
    }

    public function getPIC($system_name)
    {
        return $this->SystemApplicationsInterfaces->getPIC($system_name)->system_pic_nik;
    }
}
