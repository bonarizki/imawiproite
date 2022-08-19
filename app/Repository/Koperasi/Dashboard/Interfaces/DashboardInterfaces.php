<?php

namespace App\Repository\Koperasi\Dashboard\Interfaces;

interface DashboardInterfaces
{
    public static function GetMenuByUrl($request);

    public static function getTotalMember();

    public static function getTotalOrderMember($request);

    public static function getTotalOrderStatus($request);

    public static function top_spender_t_m($request); // spender bulan ini

    public static function top_spender_m_2($request); // spender 2 bulan terakhir

    public static function top_spender_m_1($request); // spender 1 bulan terakhir

    public static function most_order($request);

    public static function brand_rank($request);
}