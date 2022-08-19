<?php 

namespace App\Services\Dashboard;
use App\Repository\Dashboard\Menu\Interfaces\MenuInterfaces;

class HomeService
{
    private $MenuInterfaces;

    public function __construct(MenuInterfaces $MenuInterfaces)
    {
        $this->MenuInterfaces = $MenuInterfaces;
    }
    public function getBreadcum($request)
    {
        return $this->MenuInterfaces->GetMenuByUrl($request);
    }
}