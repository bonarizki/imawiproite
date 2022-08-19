<?php

namespace App\Services\Resignation;

use App\Repository\Resignation\Dashboard\Interfaces\DashboardInterfaces;

class DashboardService
{
    private $DashboardInterfaces;

    public function __construct(DashboardInterfaces $DashboardInterfaces)
    {
        $this->DashboardInterfaces = $DashboardInterfaces;
    }

    public function getBreadcum($request)
    {
        return $this->DashboardInterfaces->GetMenuByUrl($request);
    }
}