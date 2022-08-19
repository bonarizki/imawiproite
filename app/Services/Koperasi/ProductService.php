<?php

namespace App\Services\Koperasi;

use App\Repository\Koperasi\Product\Interfaces\ProductInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;
use App\Events\Koperasi\AddCartEvent;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductService
{
    private $ProductInterfaces, $HelperService;

    public function __construct(ProductInterfaces $ProductInterfaces, HelperService $HelperService)
    {
        $this->ProductInterfaces = $ProductInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getProduct($request)
    {
        return $this->ProductInterfaces->getProduct($request);
    }

    public function getCategoryProduct($request)
    {
        return $this->ProductInterfaces->getCategoryProduct($request);
    }

    public function getBrandProduct()
    {
        return $this->ProductInterfaces->getBrandProduct();
    }

    public function getDetailProduct($id)
    {
        return $this->ProductInterfaces->getDetailProduct($id);
    }

    /**
     * addCart menambahkan item kedalam cart user
     *
     * @param  mixed $request
     * @return void
     */
    public function addCart($request)
    {
        $detail = $this->getDetailProduct($request->product_id); // mendapatkan detail item
        $total = $this->countTotal($detail, 1); // menghitung total harga setelah di kurangi discount, 1 default qty ketika menambahkan barang ke cart
        $request->merge([
            'user_nik' => Auth::user()->user_nik,
            'qty' => 1, //default qty ketika menambahkan barang ke cart
            'category_id' => $detail->category_id,
            'brand_rank' => $detail->brand_rank,
            'range_rank' => $detail->range_rank,
            'total' => $total,
            'diskon_1' => $detail->ProductSetting != null ? $detail->ProductSetting->diskon_1 : 0,
            'diskon_2' => $detail->ProductSetting != null ? $detail->ProductSetting->diskon_2 : 0,
            'diskon_3' => $detail->ProductSetting != null ? $detail->ProductSetting->diskon_3 : 0,
        ]);

        $request = $this->HelperService->addAuthInsert($request);

        return $this->ProductInterfaces->addCart($request);
    }

    public function updateQty($request)
    {
        $detail_item = $this->ProductInterfaces->getDetailItemCart($request->order_detail_id);
        $detail = $this->getDetailProduct($detail_item->product_id); // mendapatkan detail item
        $request = $this->HelperService->addAuthUpdate($request);
        $request->merge([
            "total" => $this->countTotal($detail,$request->qty)
        ]);
        return $this->ProductInterfaces->updateQty($request);
    }

    public function deleteCart($request)
    {
        return $this->ProductInterfaces->deleteCart($request);
    }

    public function CountCart()
    {
        return $this->ProductInterfaces->CountCart(Auth::user()->user_nik);
    }

    public function detailCartUser()
    {
        return $this->ProductInterfaces->detailCartUser(Auth::user()->user_nik);
    }
    
    /**
     * countDiscount menghitung diskon (diskon_1 + diskon_2 + diskon_3)
     *
     * @param  mixed $data is detail item with relation ProductSetting
     * @return void
     */
    public function countDiscount($data)
    {
        $diskon = 0;
        $productSetting = $data->ProductSetting;
        if (isset($productSetting)) {
            $diskon = $productSetting->diskon_1 + $productSetting->diskon_2 + $productSetting->diskon_3;
        }

        return $diskon;
    }

    /**
     * countTotal menghitung total harga yang perlu dibayar setelah dikurangi discount
     *
     * @param  mixed $data is detail item with relation ProductSetting
     * @param  mixed $qty
     * @return void
     */
    public function countTotal($data, $qty)
    {
        $total = $data->product_price_koperasi;
        $discount = $this->countDiscount($data);
        if ($discount > 0) {
            $total_harga = $data->product_price_koperasi * $qty;
            $diskon_harga = ($total_harga / 100) * (int) $discount;
            $total = $total_harga - $diskon_harga; 
        }

        return $total;
    }
}
