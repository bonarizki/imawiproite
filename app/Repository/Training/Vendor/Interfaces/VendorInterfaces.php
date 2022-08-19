<?php

namespace App\Repository\Training\Vendor\Interfaces;

interface VendorInterfaces
{
    public static function getAllData();
    public static function insert($request);
    public static function getDetail($id);
    public static function update($request);
    public static function destroy($request);
    public static function getBytype($vendor_type);
    public static function upload($request,$row);
}