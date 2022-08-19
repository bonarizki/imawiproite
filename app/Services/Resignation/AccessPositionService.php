<?php

namespace App\Services\Resignation;

use App\Repository\Resignation\AccessPosition\Interfaces\AccessPositionInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;

class AccessPositionService
{
    private $AccessPositionInterfaces;
    private $HelperService;

    public function __construct(AccessPositionInterfaces $AccessPositionInterfaces, HelperService $HelperService)
    {
        $this->AccessPositionInterfaces = $AccessPositionInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getData()
    {
        $data = $this->AccessPositionInterfaces->getData();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function detailAccessPosition($id)
    {
        return $this->AccessPositionInterfaces->detailAccessPosition($id);
    }

    public function updateAccessPosition($request)
    {
        $parent = $request->menu_parent == null ? '' : implode(',', $request->menu_parent);
        $child = $request->menu_child == null ? '' : implode(',', $request->menu_child);
        $grand_child = $request->menu_grand_child == null ? '' : implode(',', $request->menu_grand_child);
        $menu = $parent . '#' . $child . '#' . $grand_child;
        $request->merge(['updated_by' => Auth::user()->user_name, 'menu' => $menu]);
        $request->request->remove('menu_child');
        $request->request->remove('menu_parent');
        $request->request->remove('menu_grand_child');
        return $this->AccessPositionInterfaces->updateAccessPosition($request);
    }
}
