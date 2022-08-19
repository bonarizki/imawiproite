<?php

namespace App\Repository\Ticketing\SystemApplications;

use App\Repository\Ticketing\SystemApplications\Interfaces\SystemApplicationsInterfaces;
use App\Model\Ticketing\SystemApplication;
use Illuminate\Support\Facades\DB;

class SystemApplicationsRepository implements SystemApplicationsInterfaces
{
    public static function getAllData()
    {
        return SystemApplication::all()->makeVisible(['updated_by','updated_at']);
    }

    public static function insert($request)
    {
        DB::transaction(function () use($request) {
            $data = SystemApplication::create($request->except('_token'));
            $request->merge([
                "system_id" => $data->system_id
            ]);
            \Helper::instance()->log('CREATE',$request,'App\Model\Ticketing\SystemApplication');
        });
    }

    public static function edit($id)
    {
        return SystemApplication::find($id);
    }

    public static function update($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Ticketing\SystemApplication');
            SystemApplication::find($request->system_id)
                ->update($request->except('_token'));
        });
    }

    public static function destroy($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Ticketing\SystemApplication');
            SystemApplication::find($request->system_id)->delete();
        });
    }

    public static function getPIC($system_name)
    {
        return SystemApplication::select('system_pic_nik')
            ->where('system_name',$system_name)
            ->first();
    }

}