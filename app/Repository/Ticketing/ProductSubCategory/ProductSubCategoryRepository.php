<?php

namespace App\Repository\Ticketing\ProductSubCategory;

use App\Repository\Ticketing\ProductSubCategory\Interfaces\ProductSubCategoryInterfaces;
use App\Model\Ticketing\ProductSubCategory;
use Illuminate\Support\Facades\DB;

class ProductSubCategoryRepository implements ProductSubCategoryInterfaces
{
    public static function getData()
    {
        return ProductSubCategory::all()
            ->makeVisible(['updated_at','updated_by']);
    }

    public static function store($request)
    {
        DB::transaction(function () use($request) {
            $data = ProductSubCategory::create($request->except('_token'));
            $request->merge([
                "sub_category_id" => $data->sub_category_id
            ]);
            \Helper::instance()->log('INSERT',$request,'App\Model\Ticketing\ProductSubCategory');
        });
    }

    public static function edit($id)
    {
        return ProductSubCategory::find($id);
    }

    public static function update($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Ticketing\ProductSubCategory');
            ProductSubCategory::find($request->sub_category_id)
                ->update($request->except('_token'));
        });
    }

    public static function destroy($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Ticketing\ProductSubCategory');
            ProductSubCategory::find($request->sub_category_id)
                ->delete();
        });
    }
}