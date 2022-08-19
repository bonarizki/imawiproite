<?php

namespace App\Repository\Dashboard\Module\Interfaces;

interface ModuleInterfaces
{
    public function insertModule($newRequest);

    public function updateModule($newRequest);

    public function getUserAccess();

    public function getModuleByid($id);

    public function deleteModule($request);

    public function getAllModule();

    public function getAllModuleActive();

    public function getActiveModuleByName($module_name);  //for check is module exists or not

    public static function getModuleByName($module_name);
    
    public static function getModuleWhereIn($module_id);
}