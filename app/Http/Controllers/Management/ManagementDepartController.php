<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;
use App\Services\Dashboard\DepartmentService;
use App\Services\Dashboard\UserService;


class ManagementDepartController extends Controller
{
    private $DepartmentService;
    public function __construct(DepartmentService $DepartmentService,UserService $UserService)
    {
       $this->DepartmentService = $DepartmentService;
    }

    public function index(UserService $UserService)
    {
        $data = $UserService->HandleIndex();
        $module = $data['module'];
        $menu = $data['menu'];
        $menu_child = $data['menu_child'];
        $menu_grand_child = $data['menu_grand_child'];
        return view('management/departement', compact('module', 'menu', 'menu_child', 'menu_grand_child'));
    }

    public function AllDepartment()
    {
        return $this->DepartmentService->getAllDepartment();
        
    }

    public function getDepartmentById($id)
    {
        $data = $this->DepartmentService->getDepartmentById($id);
        return response()->json(["statu"=>"success","data"=>$data]);
    }

    public function updateDepartment(DepartmentRequest $request)
    {
        $this->DepartmentService->updateDepartment($request);
        return response()->json(["status"=>"success","message"=>"Department Updated"]);
    }

    public function deleteDepartment(Request $request)
    {
        $this->DepartmentService->deleteDepartment($request);
        return response()->json(["status"=>"success","message"=>"Department Deleted"]);
    }

    public function insertDepartment(DepartmentRequest $request){
        $this->DepartmentService->insertDepartment($request);
        return response()->json(["status"=>"success","message"=>"Department Added"]);
    }

    public function getAccessPosition(Request $request)
    {
        $access = $this->DepartmentService->getAccessDepartment($request);
        return response()->json($access);
    }

    public function saveAccessPosition(Request $request)
    {
        $access = $this->DepartmentService->saveAccessDepartment($request);
        return response()->json($access);
    }
}
