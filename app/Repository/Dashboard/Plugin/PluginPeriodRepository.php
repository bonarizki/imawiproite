<?php

namespace App\Repository\Dashboard\Plugin;

use App\Repository\Dashboard\Plugin\Interfaces\PluginPeriodInterfaces;
use Yajra\DataTables\DataTables;
use App\Model\Plugin\PluginPeriod;
use Illuminate\Support\Facades\DB;

class PluginPeriodRepository implements PluginPeriodInterfaces
{
    public function getAllPluginPeriod($request)
    {
        $query = DB::table('mst_plugin_period')->whereNull('deleted_at');
        $request->period_name!=null ? $query->where('period_name','like','%'.$request->period_name.'%') : '';
        $request->period_status!=null ? $query->where('period_status','like','%'.$request->period_status.'%') : '';
        return $query->get();
    }

    public function getAllPluginPeriodActive()
    {
        return PluginPeriod::where('period_status',1)->get();
    }

    public function getPluginPeriodById($id)
    {
        return PluginPeriod::find($id);
    }

    public function  updatePluginPeriodById($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Plugin\PluginPeriod');
            PluginPeriod::find($request->period_id)
                    ->update($request->except('_token'));
        });
    }

    public function insertPluginPeriod($request)
    {
        DB::transaction(function () use($request) {
            PluginPeriod::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\Plugin\PluginPeriod');
        });
    }

    public function deletePluginPeriod($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Plugin\PluginPeriod');
            PluginPeriod::find($request->period_id)
                        ->delete();
        });
    }

    public function GetPeriodIdUseName($period_name)
    {
        return PluginPeriod::select("period_id")
                            ->where("period_name",$period_name)
                            ->first();
    }
}