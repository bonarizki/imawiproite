<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\Menu\Interfaces\MenuInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;

class MenuService
{
    private $MenuInterfaces,$HelperService;

    public function __construct(MenuInterfaces $MenuInterfaces,HelperService $HelperService)
    {
        $this->MenuInterfaces = $MenuInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getAllMenu()
    {
        $data = $this->MenuInterfaces->getAllMenu();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getChildMenu($id)
    {
        $data = $this->MenuInterfaces->getChildMenu($id);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getGrandChildMenu($id)
    {
        $data = $this->MenuInterfaces->getGrandChildMenu($id);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function insertMenu($request){
        $model = $this->getModel($request);
        $array = [
            "created_by" => Auth::user()->user_name,
            "updated_by" => Auth::user()->user_name,
        ];
        $request = $this->MenuStatus($request);
        $request->merge($array);
        $request->request->remove('TypeMenu');
        return $this->MenuInterfaces->insertMenu($request,$model);
    }

    function getModel($request)
    {
        if ($request->TypeMenu == 'menu_parent') {
            $model = 'App\Model\Menu\Menu';
        } elseif ($request->TypeMenu == 'menu_child') {
            $model = 'App\Model\Menu\MenuChild';
        } elseif ($request->TypeMenu == 'menu_grand_child') {
            $model = 'App\Model\Menu\MenuGrandChild';
        }

        return $model;
    }

    public function getDetailMenuById($request)
    {
        $model = $this->getModel($request);
        if ($request->TypeMenu == 'menu_grand_child') {
            return $this->MenuInterfaces->DetailUsewith($request,$model);
        } else {
            return $this->MenuInterfaces->DetailUseFind($request,$model);
        }
    }

    public function updateMenu($request)
    {
        $model = $this->getModel($request);
        $id = $request->TypeMenu . '_id';
        $request->merge(["updated_by" => Auth::user()->user_name]);
        $request = $this->MenuStatus($request);
        $newRequest = $request;
        $request->request->remove('TypeMenu');
        return $this->MenuInterfaces->UpdateMenu($request, $newRequest, $model, $id);
    }

    public function deleteMenu($request)
    {
        $model = $this->getModel($request);
        $request->merge([$request->TypeMenu . '_id' => $request->id]);
        return $this->MenuInterfaces->deleteMenu($request, $model);
    }

    public function MenuStatus($request)
    {
        if ($request->TypeMenu == 'menu_parent' && $request->menu_parent_status == null) {
            $request->merge(["menu_parent_status"=>0]);
        }elseif ($request->TypeMenu == 'menu_parent' && $request->menu_parent_status != null) {
            $request->merge(["menu_parent_status"=>1]);
        }

        return $request;
    }
}