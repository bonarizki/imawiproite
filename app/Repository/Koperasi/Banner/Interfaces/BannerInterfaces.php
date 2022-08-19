<?php

namespace App\Repository\Koperasi\Banner\Interfaces;

interface BannerInterfaces
{
    public static function getAllData();

    public static function addBanner($request);

    public static function delete($request);

    public static function update($request);

    public static function edit($id);

}