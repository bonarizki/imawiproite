<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\MenuService;
use App\Http\Requests\MenuRequest;

class MenuController extends Controller
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

    public function store(MenuRequest $request)
    {
        $this->MenuService->insertMenu($request);
        return response()->json(["status" => "success", "message" => "Menu Added"]);
    }

    public function show(Request $request)
    {
        $data = $this->MenuService->getDetailMenuById($request);
        return response()->json(["status" => "success", "data" => $data]);
    }
    
    function update(MenuRequest $request)
    {
        $this->MenuService->updateMenu($request);
        return response()->json(["status" => "success", "message" => "Menu Updated"]);
    }

    public function destroy(Request $request)
    {
        $this->MenuService->deleteMenu($request);
        return response()->json(["status" => "success", "message" => "Menu Deleted"]);
    }
}