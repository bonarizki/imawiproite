<?php

namespace App\Repository\Training\Category;

use App\Repository\Training\Category\Interfaces\CategoryInterfaces;
use App\Model\Training\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryInterfaces
{
    public static function getData()
    {
        return Category::all();
    }

    public static function insert($request)
    {
        return DB::transaction(function () use($request) {
            $data = Category::create($request->except('_token'));
            $request->merge([
                "category_id" => $data->category_id
            ]);
            \Helper::instance()->log('CREATE',$request,'App\Model\Training\Category');
        });
    }

    public static function getDetail($id)
    {
        return Category::find($id);
    }

    public static function update($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Training\Category');
            Category::find($request->category_id)->update($request->except('_token'));
        });
    }

    public static function destroy($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Training\Category');
            Category::find($request->category_id)->delete();
        });
    }
}