<?php

namespace App\Repository\Ticketing\ProductCategory;

use App\Repository\Ticketing\ProductCategory\Interfaces\ProductCategoryInterfaces;
use App\Model\Ticketing\ProductCategory;
use Illuminate\Support\Facades\DB;

class productCategoryRepository implements ProductCategoryInterfaces
{
    public static function getData()
    {
        return ProductCategory::with('SubProductCategory')
            ->get()
            ->makeVisible(['updated_at','updated_by']);
    }

    public static function store($request)
    {
        DB::transaction(function () use($request){
            $data = ProductCategory::create($request->except('_token'));
            $request->merge([
                'category_id' => $data->category_id
            ]);
            \Helper::instance()->log('INSERT',$request,'App\Model\Ticketing\ProductCategory');
        });
    }

    public static function edit($id)
    {
        return ProductCategory::find($id);
    }

    public static function update($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Ticketing\ProductCategory');
            ProductCategory::find($request->category_id)
                ->update($request->except('_token'));
        });
    }

    public static function destroy($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Ticketing\ProductCategory');
            ProductCategory::find($request->category_id)
                ->delete();
        });
    }
}