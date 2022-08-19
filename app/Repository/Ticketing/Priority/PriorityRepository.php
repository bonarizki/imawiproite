<?php

namespace App\Repository\Ticketing\Priority;

use App\Repository\Ticketing\Priority\Interfaces\PriorityInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Ticketing\Priority;

class PriorityRepository implements PriorityInterfaces
{
    public static function index()
    {
        return Priority::all()->makeVisible(['updated_by','updated_at']);
    }

    public static function store($request)
    {
        return DB::transaction(function () use($request) {
            $data = Priority::create($request->except('_token'));
            $request->merge([
                "priority_id" => $data->priority_id
            ]);
            \Helper::instance()->log('CREATE',$request,'App\Model\Ticketing\Priority');
        });
    }

    public static function edit($id)
    {
        return Priority::find($id);
    }

    public static function update($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Ticketing\Priority');
            Priority::find($request->priority_id)->update($request->except('_token'));
        });
    }

    public static function destroy($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Ticketing\Priority');
            Priority::find($request->priority_id)->delete();
        });
    }
}