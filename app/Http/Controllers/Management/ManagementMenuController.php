<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use Illuminate\Http\Request;
use App\Services\Dashboard\MenuService;


class ManagementMenuController extends Controller
{
    private $MenuService;

    public function __construct(MenuService $MenuService)
    {
        $this->MenuService = $MenuService;
    }

    public function getAllMenu()
    {
        return $this->MenuService->getAllMenu();
    }

    public function getChildMenu($id)
    {
        return $this->MenuService->getChildMenu($id);
    }

    public function getGrandChildMenu($id)
    {
        return $this->MenuService->getGrandChildMenu($id);
    }

    public function insertMenu(MenuRequest $request)
    {
        $this->MenuService->insertMenu($request);
        return response()->json(["status" => "success", "message" => "Menu Added"]);
    }

    public function getDetailMenuById(Request $request)
    {
        $data = $this->MenuService->getDetailMenuById($request);
        return response()->json(["status" => "success", "data" => $data]);
    }
    
    function updateMenu(MenuRequest $request)
    {
        $this->MenuService->updateMenu($request);
        return response()->json(["status" => "success", "message" => "Menu Updated"]);
    }

    public function deleteMenu(Request $request)
    {
        $this->MenuService->deleteMenu($request);
        return response()->json(["status" => "success", "message" => "Menu Deleted"]);
    }

}
