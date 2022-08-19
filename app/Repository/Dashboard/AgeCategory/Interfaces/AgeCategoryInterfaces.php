<?php

namespace App\Repository\Dashboard\AgeCategory\Interfaces;

interface AgeCategoryInterfaces
{
    public static function allData();

    public static function insert($request);

    public static function edit($id);

    public static function update($request);

    public static function delete($request);
}