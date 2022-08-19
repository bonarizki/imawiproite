<?php

namespace App\Repository\Dashboard\Department\Interfaces;

interface DepartmentInterfaces
{
    public function getAllDepartment();

    public function getDepartmentById($id);

    public function updateDepartment($request,$data);

    public function deleteDepartment($request);

    public function insertDepartment($request);

    public function getAccessDepartment($request);

    public function saveAccessDepartment($request,$module,$menu);

    public function getDataByName($name);

    public function AccessPositionRegven();
}