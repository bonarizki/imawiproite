<?php

namespace App\Repository\Ticketing\ProductCategory\Interfaces;

interface ProductCategoryInterfaces
{
    public static function getData();
    public static function store($request);
    public static function update($request);
    public static function edit($id);
    public static function destroy($request);
}