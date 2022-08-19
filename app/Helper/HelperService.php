<?php 

namespace App\Helper;

use Yajra\DataTables\DataTables;
use App\Repository\Dashboard\Plugin\Interfaces\PluginPeriodInterfaces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HelperService
{
    private $PluginPeriodInterfaces;
    public function __construct(PluginPeriodInterfaces $PluginPeriodInterfaces)
    {
        $this->PluginPeriodInterfaces = $PluginPeriodInterfaces;
    }

    public function DataTablesResponse($data)
    {
        return DataTables::of($data)
                        ->addIndexColumn()
                        ->make(true);
    }

    public function Module($request)
    {
        $data['module'] = '';
        if($request->module) {
            $data['module'] = implode('#', $request->module);
        }

        $parent = '';
        if($request->menu_parent) {
            $parent = implode(',', $request->menu_parent);
        }

        $child = '';
        if($request->menu_child) {
            $child = implode(',', $request->menu_child);
        }

        $grand_child = '';
        if($request->menu_grand_child) {
            $grand_child = implode(',', $request->menu_grand_child);
        }

        $data['menu'] = $parent.'#'.$child.'#'.$grand_child;

        return $data;
    }

    public function lowerAndReplace($words)
    {
        return strtolower(str_replace(" ", "_", $words));
    }

    public function removeCharSpasi($words)
    {
        $removeSpace = str_replace(' ','',$words);
        $removemin = str_replace('-','',$removeSpace);
        return $removemin;
    }

    public function getIdPriodNow() // mendapatkan period saat ini berdasarkan tahun
    {
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        return $this->getIdPeriod($period_name);
    }

    public function getIdPeriod($period_name) // mendapatkan id period berdasarkan period namenya
    {
        $data = $this->PluginPeriodInterfaces->GetPeriodIdUseName($period_name);
        try {
            $data->period_id;
        } catch (\Throwable $th) {
            throw new ModelNotFoundException('plugin period not set');
        }
        return $data->period_id;
    }

    public function addAuthInsert($request)
    {
        $array = [
            "created_by" => Auth::user()->user_name,
            "updated_by" => Auth::user()->user_name,
        ];

        return $request->merge($array);
    }

    public function addAuthUpdate($request)
    {
        $array = [
            "updated_by" => Auth::user()->user_name,
        ];

        return $request->merge($array);
    }
}