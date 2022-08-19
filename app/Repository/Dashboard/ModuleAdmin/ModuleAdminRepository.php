<?php

namespace App\Repository\Dashboard\ModuleAdmin;

use App\Repository\Dashboard\ModuleAdmin\Interfaces\ModuleAdminInterfaces;
use App\Model\ModuleAdmin;
use Illuminate\Support\Facades\DB;

class ModuleAdminRepository implements ModuleAdminInterfaces
{
    public static function getAdminByModuleId($id_module)
    {
        return ModuleAdmin::with(['User'])->where('module_id',$id_module)->get();
    }

    public static function create($request)
    {
        return DB::transaction(function () use ($request) {
            $admin = ModuleAdmin::create($request->except('_token'));
            $request->merge([
                'admin_id' => $admin->admin_id
            ]);
            \Helper::instance()->log('CREATE',$request,'App\Model\ModuleAdmin');
        });
    }

    public static function edit($admin_id)
    {
        return ModuleAdmin::find($admin_id);
    }

    public static function update($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\ModuleAdmin');
            ModuleAdmin::find($request->admin_id)
                ->update($request->except('_token'));
        });
    }

    public static function delete($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\ModuleAdmin');
            ModuleAdmin::find($request->admin_id)
                ->delete();
        });
    }
}
