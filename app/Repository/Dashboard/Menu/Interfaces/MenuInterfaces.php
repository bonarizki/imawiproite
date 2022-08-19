<?php

namespace App\Repository\Dashboard\Menu\Interfaces;

interface MenuInterfaces
{
    public function getAllMenu();

    public function getAllMenuChild();

    public function getAllMenuGrandChild();

    public function getChildMenu($id);

    public function getGrandChildMenu($id);

    public function insertMenu($request,$model);

    public function DetailUseWith($request,$model);

    public function DetailUseFind($request,$model);

    public function UpdateMenu($request, $newRequest, $model, $id);

    public function deleteMenu($request, $model);

    public function GetMenuByUrl($request);

}