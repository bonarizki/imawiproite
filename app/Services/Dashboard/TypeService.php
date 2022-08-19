<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\Type\Interfaces\TypeInterfaces;
use Illuminate\Support\Facades\Auth;
use App\Helper\HelperService;

class TypeService
{
    private $TypeInterfaces,$HelperService;

    public function __construct(TypeInterfaces $TypeInterfaces,HelperService $HelperService)
    {
        $this->TypeInterfaces = $TypeInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getAllType()
    {
        $data = $this->TypeInterfaces->getAllType();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getTypeById($id)
    {
        return $this->TypeInterfaces->getTypeById($id);
    }

    public function updateType($request)
    {
        $request->merge(["updated_by" => Auth::user()->user_name]);
        return $this->TypeInterfaces->updateType($request);
    }

    public function deleteType($request)
    {
        return $this->TypeInterfaces->deleteType($request);
    }

    public function insertType($request)
    {
        $request->merge(["created_by" => Auth::user()->user_name, "updated_by" => Auth::user()->user_name]);
        return $this->TypeInterfaces->insertType($request);
    }
}