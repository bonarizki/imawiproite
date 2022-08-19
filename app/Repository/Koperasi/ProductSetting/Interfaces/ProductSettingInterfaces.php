<?php

namespace App\Repository\Koperasi\ProductSetting\Interfaces;

interface ProductSettingInterfaces
{
    public static function ProductBlackList($request);

    public static function getSettingByProductCode($product_code);

    public static function create($request);

    public static function update($request);

}