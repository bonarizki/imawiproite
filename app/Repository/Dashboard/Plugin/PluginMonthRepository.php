<?php

namespace App\Repository\Dashboard\Plugin;

use App\Repository\Dashboard\Plugin\Interfaces\PluginMonthInterfaces;
use Yajra\DataTables\DataTables;
use App\Model\Plugin\PluginMonth;
use Illuminate\Support\Facades\DB;

class PluginMonthRepository implements PluginMonthInterfaces
{
    public function getAllPluginMonth($request)
    {
        $query = DB::table('mst_plugin_month')->whereNull('deleted_at');
        $request->month_name!=null ? $query->where('month_name','like','%'.$request->month_name.'%') : '';
        $request->month_sequence!=null ? $query->where('month_sequence','like','%'.$request->month_sequence.'%') : '';
        return $query->get();
    }

    public function getPluginMonthById($id)
    {
        return PluginMonth::find($id);
    }

    public function updatePluginMonthId($request)
    {
        DB::transaction(function () use($request){
            \Helper::instance()->log('UPDATE',$request,'App\Model\Plugin\PluginMonth');
            PluginMonth::where('month_id',$request->month_id)
                        ->update($request->except('_token'));
        });
    }

    public function insertPluginMonth($request)
    {
        DB::transaction(function () use($request) {
            PluginMonth::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\Plugin\PluginMonth');
            
        });
    }

    public function deletePluginMonth($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Plugin\PluginMonth');
            PluginMonth::find($request->month_id)
                        ->delete();
        });
    }
}