<?php

namespace App\Repository\Dashboard\Plugin;

use App\Repository\Dashboard\Plugin\Interfaces\PluginVersionInterfaces;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Model\Plugin\PluginVersion;

class PluginVersionRepository implements PluginVersionInterfaces
{
    public function getAllPluginVersion($request)
    {
        $query = DB::table('mst_plugin_version')->whereNUll('deleted_at');
        $request->version_code!=null ? $query->where('version_code','like','%'.$request->version_code.'%') : '';
        $request->version_name!=null ? $query->where('version_name','like','%'.$request->version_name.'%') : '';
        $request->version_status!=null ? $query->where('version_status','like','%'.$request->version_status.'%') : '';
        return $query->get();
    }

    public function getPluginVersionId($id)
    {
        return PluginVersion::find($id);
    }

    public function updatePluginVersionId($request)
    {
        $request->version_status == 1 ? PluginVersion::UpdateVersion() : '';
        DB::transaction(function () use($request){
            \Helper::instance()->log('UPDATE',$request,'App\Model\Plugin\PluginVersion');
            PluginVersion::where('version_id',$request->version_id)
                        ->update($request->except('_token'));
        });
    }

    public function insertPluginVersion($request)
    {
        $request->version_status == 1 ? PluginVersion::UpdateVersion() : '';
        DB::transaction(function () use($request){
            PluginVersion::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\Plugin\PluginVersion');
        });
    }

    public function deletePluginVersion($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Plugin\PluginVersion');
            PluginVersion::find($request->version_id)
                        ->delete();
        });
    }
}