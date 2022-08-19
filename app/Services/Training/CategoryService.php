<?php

namespace App\Services\Training;

use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;
use App\Repository\Training\Category\Interfaces\CategoryInterfaces;

class CategoryService
{
    private $HelperService; 
    private $CategoryInterfaces; 

    public function __construct(HelperService $HelperService, CategoryInterfaces $CategoryInterfaces)
    {
        $this->CategoryInterfaces = $CategoryInterfaces;
        $this->HelperService = $HelperService;
    }

    public function show()
    {
        $data = $this->CategoryInterfaces->getData();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function create($request)
    {
        $request = $this->HelperService->addAuthInsert($request);
        return $this->CategoryInterfaces->insert($request);
    }

    public function detail ($id)
    {
        return $this->CategoryInterfaces->getDetail($id);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->CategoryInterfaces->update($request);
    }

    public function destroy($request)
    {
        return $this->CategoryInterfaces->destroy($request);
    }
}