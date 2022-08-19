<?php

namespace App\Repository\Koperasi\Order\Interfaces;

interface OrderInterfaces 
{
    public static function totalOrderUser($user_nik);

    public static function getLastId();

    public static function create($request);

    public static function updateDetail($request);

    public static function detailOrderUser($order_header_id); // mendapatkan data order user yang sudah memiliki order header id
    
    public static function allOrder($request);

    public static function deleteHeader($request);

    public static function deleteDeteail($request);

    public static function HeaderDetail($id);

    public static function updateHeader($request);

    public static function getJurnalID($order_header_id); // mendapatkan id jurnal yang tersimpan di header
}