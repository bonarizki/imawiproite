<?php

namespace App\Repository\Training\TrainingMethod;

use App\Repository\Training\TrainingMethod\Interfaces\TrainingMethodInterfaces;
use App\Model\Training\TrainingMethod;
use Illuminate\Support\Facades\DB;

class TrainingMethodRepository implements TrainingMethodInterfaces
{
    public static function getData()
    {
        return TrainingMethod::all();
    }

    public static function insert($request)
    {
        return DB::transaction(function () use($request) {
            $data = TrainingMethod::create($request->except('_token'));
            $request->merge([
                "method_id" => $data->category_id
            ]);
            \Helper::instance()->log('CREATE',$request,'App\Model\Training\TrainingMethod');
        });
    }

    public static function getDetail($id)
    {
        return TrainingMethod::find($id);
    }

    public static function update($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Training\TrainingMethod');
            TrainingMethod::find($request->method_id)->update($request->except('_token'));
        });
    }

    public static function destroy($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Training\TrainingMethod');
            TrainingMethod::find($request->category_id)->delete();
        });
    }
}