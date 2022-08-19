<?php

namespace App\Repository\Koperasi\OrderLimit;

use App\Model\Koperasi\OrderLimit;
use App\Repository\Koperasi\OrderLimit\Interfaces\OrderLimitInterfaces;
use Illuminate\Support\Facades\DB;

class OrderLimitRepository implements OrderLimitInterfaces
{
    public static function index()
    {
        return OrderLimit::With(['Product'])
            ->get()
            ->makeVisible(['updated_at','updated_by']);
    }

    public static function insert($request)
    {
        return DB::transaction(function () use($request) {
            $OrderLimit = OrderLimit::create($request->except('_token'));
            $request->merge([
                'order_limit_id' => $OrderLimit->order_limit_id
            ]);
            \Helper::instance()->log('INSERT',$request,'App\Model\Koperasi\OrderLimit');
        });
    }

    public static function edit($id)
    {
        return OrderLimit::With(['Product'])
            ->where('order_limit_id',$id)
            ->first();
    }

    public static function update($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Koperasi\OrderLimit');
            OrderLimit::find($request->order_limit_id)
                ->update($request->except('_token'));
        });
    }

    public static function delete($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Koperasi\OrderLimit');
            OrderLimit::find($request->order_limit_id)
                ->delete();
        });
    }
}