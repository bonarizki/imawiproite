<?php

namespace App\Repository\Koperasi\Product\Interfaces;

interface ProductInterfaces
{
    public static function getProduct($request);

    public static function getCategoryProduct($request);

    public static function getDetailProduct($id);

    public static function getBrandProduct();

    public static function addCart($request);

    public static function updateQty($request);

    public static function deleteCart($request);

    public static function CountCart($user_nik);

    public static function detailCartUser($user_nik);

    public static function getDetailItemCart($order_detail_id);

}