<?php

namespace App\Services\Ticketing;

use App\Repository\Ticketing\ProductSubCategory\Interfaces\ProductSubCategoryInterfaces;
use App\Helper\HelperService;

class ProductSubCategoryService
{
    public $ProductSubCategoryInterfaces;
    public $HelperService;

    public function __construct(HelperService $HelperService,ProductSubCategoryInterfaces $ProductSubCategoryInterfaces)
    {
        $this->ProductSubCategoryInterfaces = $ProductSubCategoryInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getData()
    {
        $data = $this->ProductSubCategoryInterfaces->getData();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function store($request)
    {
        $this->HelperService->addAuthInsert($request);
        return $this->ProductSubCategoryInterfaces->store($request);
    }

    public function edit($id)
    {
        return $this->ProductSubCategoryInterfaces->edit($id);
    }

    public function update($request)
    {
        $this->HelperService->addAuthUpdate($request);
        return $this->ProductSubCategoryInterfaces->update($request);
    }

    public function destroy($id)
    {
        $request = \Helper::instance()->MakeRequest(["sub_category_id"=>$id]);
        return $this->ProductSubCategoryInterfaces->destroy($request);
    }
}