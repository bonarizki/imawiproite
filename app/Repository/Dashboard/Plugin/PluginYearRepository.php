<?php

namespace App\Repository\Dashboard\Plugin;

use App\Repository\Dashboard\Plugin\Interfaces\PluginYearInterfaces;
use Yajra\DataTables\DataTables;
use App\Model\Plugin\PluginYear;
use Illuminate\Support\Facades\DB;

class PluginYearRepository implements PluginYearInterfaces
{
    public function getDataAllYear($request)
    {
        $query = DB::table('mst_plugin_year')->whereNull('deleted_at');
        $request->year_id!=null ? $query->where('year_id','like','%'.$request->year_id.'%') : '';
        $request->year_name!=null ? $query->where('year_name','like','%'.$request->year_name.'%') : '';
        return $query->get();
    }

    public function getAllPluginYearActive()
    {
        return PluginYear::where('year_status',1)->get();
    }

    public function getPluginYearById($id)
    {
        return PluginYear::find($id);
    }

    public function updatePluginYear($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Plugin\PluginYear');
            PluginYear::find($request->year_id)
                        ->update($request->except('_token'));
        });
    }

    public function insertPluginYear($request)
    {
        DB::transaction(function () use($request) {
            PluginYear::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\Plugin\PluginYear');
        });
    }

    public function deletePluginYear($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Plugin\PluginYear');
            PluginYear::find($request->year_id)
                        ->delete();
        });
    }

}