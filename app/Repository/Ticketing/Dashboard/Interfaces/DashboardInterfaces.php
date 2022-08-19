<?php

namespace App\Repository\Ticketing\Dashboard\Interfaces;

interface DashboardInterfaces
{
    public static function GetMenuByUrl($request);
    public static function getData($status,$request);
    public static function getAllDepartmentTicket($period_id);
}