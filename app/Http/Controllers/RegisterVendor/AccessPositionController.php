<?php

namespace App\Http\Controllers\RegisterVendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Dashboard\Department\Interfaces\DepartmentInterfaces;

class AccessPositionController extends Controller
{
    public $DepartmentInterfaces; 

    public function __construct(DepartmentInterfaces $DepartmentInterfaces)
    {
        $this->DepartmentInterfaces = $DepartmentInterfaces;
    }

    public function index()
    {
        $data = $this->DepartmentInterfaces->AccessPositionRegven();
        return response()->json($data);
    }
}
