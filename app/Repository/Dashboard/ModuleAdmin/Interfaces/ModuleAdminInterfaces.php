<?php

namespace App\Repository\Dashboard\ModuleAdmin\Interfaces;

interface ModuleAdminInterfaces {

    public static function getAdminByModuleId($id_module);

    public static function create($request);

    public static function edit($admin_id);

    public static function update($request);

    public static function delete($request);
}