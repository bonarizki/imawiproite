<?php

namespace App\Repository\Koperasi\AccessPosition;

use App\Repository\Koperasi\AccessPosition\Interfaces\AccessPositionInterfaces;
use App\Model\Koperasi\AccessPosition;
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
            \Helper::instance()->log('UPDATE',$request,'App\Model\Koperasi\AccessPosition');
            AccessPosition::find($request->access_position_id)->update($request->except('_token'));
        });
    }
}