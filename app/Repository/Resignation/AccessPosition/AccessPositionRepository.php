<?php

namespace App\Repository\Resignation\AccessPosition;

use App\Repository\Resignation\AccessPosition\Interfaces\AccessPositionInterfaces;
use App\Model\Resignation\AccessPosition;
use Illuminate\Support\Facades\DB;

class AccessPositionRepository implements AccessPositionInterfaces
{
    public function getData()
    {
        return AccessPosition::with('Department')->get();
    }

    public function detailAccessPosition($id)
    {
        return AccessPosition::with('Department')
                            ->where('access_position_id',$id)
                            ->first();
    }

    public function updateAccessPosition($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Resignation\AccessPosition');
            AccessPosition::find($request->access_position_id)->update($request->except('_token'));
        });
    }
}