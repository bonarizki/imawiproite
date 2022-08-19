<?php

namespace App\Repository\Koperasi\Product;

use App\Repository\Koperasi\Product\Interfaces\ProductInterfaces;
use App\Model\Koperasi\Product;
use App\Model\Koperasi\OrderDetail;
use App\Model\Koperasi\OrderDetailMaster;
use Illuminate\Support\Facades\DB;
use App\Model\Koperasi\ProductSetting;

class ProductRepository implements ProductInterfaces
{
    public static function getProduct($request)
    {
        $query = Product::with('ProductSetting')
                ->select(Product::selectField());

        $query = self::filter($request, $query);

        $query_skincare = Product::getProductSkincare($request); // ambil data product skincare dahulu

        $query_skincare = self::filter($request, $query_skincare);


        $mix_query = $query->union($query_skincare);

        if ($request->has('filter_harga') && $request->filter_harga != null) {
            $mix_query->orderBy('product_price_koperasi', $request->filter_harga);
        }

        return $mix_query->paginate('16') // melakukan paginate
            ->appends([
                'search_product_name' => $request->search_product_name,
                'filter_category' => $request->filter_category,
                'filter_harga' => $request->filter_harga,
                'filter_brand' => $request->filter_brand,
            ]);
    }

    public static function filter($request, $query)
    {
        if ($request->has('filter_category') && $request->filter_category != null) {
            $query->where('category_id', $request->filter_category);
        }

        if ($request->has('search_product_name') && $request->search_product_name != null) {
            $query->where('product_name', 'like', '%' . $request->search_product_name . '%');
        }

        if ($request->has('filter_brand') && $request->filter_brand != null) {
            $query->where('brand_id', $request->filter_brand);
        }

        if ($request->has('filter_harga') && $request->filter_harga != null) {
            $query->orderBy('product_price_koperasi', $request->filter_harga);
        }

        $query->where('product_status', 'Active');

        $query->whereNotIn(
            'product_code',
            ProductSetting::select('product_code')
                ->where('black_list_status', 'yes')
                ->get()
                ->toArray()
        );

        return $query;
    }

    public static function getCategoryProduct($request)
    {
        $query_skincare = Product::getProductSkincare()
            ->select('category_name', 'category_id');
        $query = Product::select(Product::selectField())
            ->union($query_skincare)
            ->select('category_name', 'category_id');

        if ($request->has('filter_brand') && $request->filter_brand != null) $query->where('brand_id', $request->filter_brand);

        return $query->groupBy('category_name')
            ->orderBy('Category_name', 'asc')
            ->get();
    }

    public static function getBrandProduct()
    {
        $query_skincare = Product::getProductSkincare()
            ->select('brand_name', 'brand_id');
        return Product::select(Product::selectField())
            ->union($query_skincare)
            ->select('brand_name', 'brand_id')
            ->where('brand_status', 'Active')
            ->groupBy('brand_name')
            ->orderBy('brand_name', 'asc')
            ->get();
    }

    public static function getDetailProduct($id)
    {
        $query_skincare = Product::getProductSkincare()->where('product_id', $id);
        return Product::select(Product::selectField())
            ->with('ProductSetting')
            ->union($query_skincare)
            ->where('product_id', $id)
            ->first();
    }

    public static function addCart($request)
    {
        return DB::transaction(function () use ($request) {
            //input order detail actual
            $OrderDetail = OrderDetail::create($request->except('_token'));
            $request->merge([
                'order_detail_id' => $OrderDetail->order_detail_id
            ]);
            \Helper::instance()->log('CREATE', $request, 'App\Model\Koperasi\OrderDetail');

            //input order detail master
            $OrderDetailMaster = OrderDetailMaster::create($request->except('_token'));
            $request->merge([
                'order_detail_id' => $OrderDetailMaster->order_detail_id
            ]);
            \Helper::instance()->log('CREATE', $request, 'App\Model\Koperasi\OrderDetailMaster');
        });
    }

    public static function updateQty($request)
    {
        return DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\Koperasi\OrderDetailMaster');
            OrderDetailMaster::find($request->order_detail_id)
                ->update($request->except('_token'));

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Koperasi\OrderDetail');
            OrderDetail::find($request->order_detail_id)
                ->update($request->except('_token'));
        });
    }

    public static function deleteCart($request)
    {
        return DB::transaction(function () use ($request) {
            \Helper::instance()->log('DELETE', $request, 'App\Model\Koperasi\OrderDetailMaster');
            OrderDetailMaster::find($request->order_detail_id)
                ->delete();

            \Helper::instance()->log('DELETE', $request, 'App\Model\Koperasi\OrderDetail');
            OrderDetail::find($request->order_detail_id)
                ->delete();
        });
    }

    public static function CountCart($user_nik)
    {
        return OrderDetail::whereNull('order_header_id')
            ->where('user_nik', $user_nik)
            ->get()
            ->count();
    }

    public static function detailCartUser($user_nik)
    {
        return OrderDetail::with([
            'Product' => function ($query) {
                return $query->select(Product::selectField())
                    ->union(Product::getProductSkincare());
            }
        ])
            ->whereNull('order_header_id')
            ->where('user_nik', $user_nik)
            ->orderBy('brand_rank')
            ->orderBy('range_rank')
            ->get();
    }

    public static function getDetailItemCart($order_detail_id)
    {
        return OrderDetail::find($order_detail_id);
    }
}
