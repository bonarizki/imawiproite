<?php

namespace App\Services\Ticketing;

use App\Repository\Ticketing\ProductCategory\Interfaces\ProductCategoryInterfaces;
use App\Helper\HelperService;

class ProductCategoryService
{
    public $ProductCategoryInterfaces;
    public $HelperService;

    public function __construct(ProductCategoryInterfaces $ProductCategoryInterfaces, HelperService $HelperService)
    {
        $this->ProductCategoryInterfaces = $ProductCategoryInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getData()
    {
        $data = $this->ProductCategoryInterfaces->getData();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function store($request)
    {
        $this->HelperService->addAuthInsert($request);
        return $this->ProductCategoryInterfaces->store($request);
    }

    public function edit($id)
    {
        return $this->ProductCategoryInterfaces->edit($id);
    }

    public function update($request)
    {
        $this->HelperService->addAuthUpdate($request);
        return $this->ProductCategoryInterfaces->update($request);
    }

    public function destroy($id)
    {
        $request = \Helper::instance()->MakeRequest(["category_id"=>$id]);
        return $this->ProductCategoryInterfaces->destroy($request);
    }
}