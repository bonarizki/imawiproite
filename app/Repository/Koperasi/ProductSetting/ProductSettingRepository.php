<?php

namespace App\Repository\Koperasi\ProductSetting;

use App\Repository\Koperasi\ProductSetting\Interfaces\ProductSettingInterfaces;
use App\Model\Koperasi\Product;
use App\Model\Koperasi\ProductSetting;
use Illuminate\Support\Facades\DB;

class ProductSettingRepository implements ProductSettingInterfaces
{
    public static function ProductBlackList($request)
    {
        $query_skincare = Product::getProductSkincare(); //mendapatkan data product skincare

        self::filterBlackList($request, $query_skincare); // melakukan filter untuk data product skincare

        $query = Product::union($query_skincare)
            ->with(['ProductSetting'])
            ->where('product_status', 'Active');

        self::filterBlackList($request, $query); // melakukan filter untuk data product skincare

        return $query->get();
    }

    public static function filterBlackList($request, $query)
    {
        if ($request->brand_search != null) $query->where('brand_id', $request->brand_search);

        if ($request->category_search != null) $query->where('category_id', $request->category_search);

        return $query;
    }

    public static function getSettingByProductCode($product_code)
    {
        return ProductSetting::where('product_code', $product_code)
            ->first();
    }

    public static function create($request)
    {
        return DB::transaction(function () use ($request) {
            $data = ProductSetting::create($request->except('_token'));
            $request->merge([
                'product_setting_id' => $data->product_setting_id
            ]);
            \Helper::instance()->log('CREATE', $request, 'App\Model\Koperasi\ProductSetting');
        });
    }

    public static function update($request)
    {
        return DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\Koperasi\ProductSetting');
            ProductSetting::find($request->product_setting_id)
                ->update($request->except('_token'));
        });
    }
}
