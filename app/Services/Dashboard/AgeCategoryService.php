<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\AgeCategory\Interfaces\AgeCategoryInterfaces;
use App\Helper\HelperService;

class AgeCategoryService 
{
    public $AgeCategoryInterfaces;
    public $HelperService;

    public function __construct(AgeCategoryInterfaces $AgeCategoryInterfaces,HelperService $HelperService)
    {
        $this->AgeCategoryInterfaces = $AgeCategoryInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getALlData()
    {
        $data = $this->AgeCategoryInterfaces->allData();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function insert($request)
    {
        $this->HelperService->addAuthInsert($request);
        return $this->AgeCategoryInterfaces->insert($request);
    }

    public function edit($id)
    {
        return $this->AgeCategoryInterfaces->edit($id);
    }

    public function update($request)
    {
        $this->HelperService->addAuthUpdate($request);
        return $this->AgeCategoryInterfaces->update($request);
    }

    public function delete($request)
    {
        return $this->AgeCategoryInterfaces->delete($request);
    }
}
