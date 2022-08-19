<?php 

namespace App\Repository\Koperasi\OrderLimit\Interfaces;

interface OrderLimitInterfaces
{
    public static function index();

    public static function insert($request);

    public static function edit($id);

    public static function update($request);

    public static function delete($request);
}