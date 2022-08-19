<?php

namespace App\Repository\Dashboard\Plugin;

use App\Repository\Dashboard\Plugin\Interfaces\PluginSettingSystemInterfaces;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Model\Plugin\SettingSystem;

class PluginSystemSettingRepository implements PluginSettingSystemInterfaces
{
    public function getAllSystemSetting($request)
    {
        $query = DB::table('mst_plugin_setting_system')->whereNull('deleted_at');
        $request->setting_system_name!=null ? $query->where('setting_system_name','like','%'.$request->setting_system_name.'%') : '';
        $request->setting_system_status!=null ? $query->where('setting_system_status','like','%'.$request->setting_system_status.'%') : '';
        return $query->get();
    }

    public function getPluginSystemSettingById($id)
    {
        return SettingSystem::find($id);
    }

    public function updatePluginSystemSettingById($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Plugin\SettingSystem');
            SettingSystem::where('setting_system_id',$request->setting_system_id)
                        ->update($request->except('_token'));
            
        });
    }

    public function insertPluginSystemSetting($request)
    {
        DB::transaction(function () use($request) {
            SettingSystem::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\Plugin\SettingSystem');
        });
    }

    public function deletePluginSystemSetting($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Plugin\SettingSystem');
            SettingSystem::find($request->setting_system_id)
                        ->delete();
        });
    }
}