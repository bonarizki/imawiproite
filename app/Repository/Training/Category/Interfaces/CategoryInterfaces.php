<?php

namespace App\Repository\Training\Category\Interfaces;

interface CategoryInterfaces
{
    public static function getData();
    public static function insert($request);
    public static function getDetail($id);
    public static function update($request);
    public static function destroy($request);
}