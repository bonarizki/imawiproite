<?php

namespace App\Repository\Dashboard\AgeCategory;

use App\Repository\Dashboard\AgeCategory\Interfaces\AgeCategoryInterfaces;
use App\Model\AgeCategory;
use Illuminate\Support\Facades\DB;

class AgeCategoryRepository implements AgeCategoryInterfaces
{
    public static function allData()
    {
        return AgeCategory::all();
    }

    public static function insert($request)
    {
        return DB::transaction(function () use ($request) {
            $data = AgeCategory::create($request->except('_token'));
            $request->merge([
                'age_category_id' => $data->age_category_id
            ]);
            \Helper::instance()->log('INSERT',$request,'App\Model\AgeCategory');
        });
    }

    public static function edit($id)
    {
        return AgeCategory::find($id);
    }

    public static function update($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\AgeCategory');
            AgeCategory::find($request->age_category_id)
                ->update($request->except('_token'));
        });
    }

    public static function delete($request)
    {
        return DB::transaction(function () use($request) {
            return DB::transaction(function () use($request) {
                \Helper::instance()->log('UPDATE',$request,'App\Model\AgeCategory');
                AgeCategory::find($request->age_category_id)
                    ->delete();
            });
        });
    }
}