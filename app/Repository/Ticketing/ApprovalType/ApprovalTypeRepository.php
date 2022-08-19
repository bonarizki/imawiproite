<?php

namespace App\Repository\Ticketing\ApprovalType;

use App\Repository\Ticketing\ApprovalType\Interfaces\ApprovalTypeInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Ticketing\ApprovalType;

class ApprovalTypeRepository implements ApprovalTypeInterfaces
{
    public static function index()
    {
        return ApprovalType::with('User')->get()->makeVisible(['updated_by','updated_at']);
    }

    public static function store($request)
    {
        return DB::transaction(function () use($request) {
            $data = ApprovalType::create($request->except('_token'));
            $request->merge([
                "priority_id" => $data->type_id
            ]);
            \Helper::instance()->log('CREATE',$request,'App\Model\Ticketing\ApprovalType');
        });
    }

    public static function edit($id)
    {
        return ApprovalType::find($id);
    }

    public static function update($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Ticketing\ApprovalType');
            ApprovalType::find($request->type_id)->update($request->except('_token'));
        });
    }

    public static function destroy($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Ticketing\ApprovalType');
            ApprovalType::find($request->type_id)->delete();
        });
    }
}