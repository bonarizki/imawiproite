<?php

namespace App\Repository\Ticketing\ProductSubCategory\Interfaces;

interface ProductSubCategoryInterfaces
{
    public static function getData();
    public static function store($request);
    public static function update($request);
    public static function destroy($request);
    public static function edit($id);
}