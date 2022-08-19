<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\Department\Interfaces\DepartmentInterfaces;
use Illuminate\Support\Facades\Auth;
use App\Helper\HelperService;

class DepartmentService
{
    private $DepartmentInterfaces,$HelperService;

    public function __construct(DepartmentInterfaces $DepartmentInterfaces,HelperService $HelperService)
    {
        $this->DepartmentInterfaces = $DepartmentInterfaces;
        $this->HelperService = $HelperService;
    }
    public function getAllDepartment()
    {
        $data = $this->DepartmentInterfaces->getAllDepartment();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getDepartmentById($id)
    {
        return $this->DepartmentInterfaces->getDepartmentById($id);
    }

    public function updateDepartment($request)
    {
        $data = array_merge($request->except('_token'),["updated_by"=>Auth::user()->user_name]);
        return $this->DepartmentInterfaces->updateDepartment($request,$data);
    }

    public function deleteDepartment($request)
    {
        return $this->DepartmentInterfaces->deleteDepartment($request);
    }

    public function insertDepartment($request)
    {
        $request->merge(["created_by"=>Auth::user()->user_name,"updated_by"=>Auth::user()->user_name]);
        return $this->DepartmentInterfaces->insertDepartment($request);
    }

    public function getAccessDepartment($request)
    {
        return $this->DepartmentInterfaces->getAccessDepartment($request);
    }

    public function saveAccessDepartment($request)
    {
        $data = $this->HelperService->Module($request);
        return $this->DepartmentInterfaces->saveAccessDepartment($request,$data['module'],$data['menu']);
    }
}