<?php

namespace App\Services\Koperasi;

use App\Repository\Koperasi\Dashboard\Interfaces\DashboardInterfaces;
use App\Helper\HelperService;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use App\Repository\Koperasi\Banner\Interfaces\BannerInterfaces;
class DashboardService
{
    private $DashboardInterfaces,$HelperService,$UserInterfaces,$BannerInterfaces;

    public function __construct(
        DashboardInterfaces $DashboardInterfaces,
        HelperService $HelperService, 
        UserInterfaces $UserInterfaces,
        BannerInterfaces $BannerInterfaces)
    {
        $this->DashboardInterfaces = $DashboardInterfaces;
        $this->HelperService = $HelperService;
        $this->UserInterfaces = $UserInterfaces;
        $this->BannerInterfaces = $BannerInterfaces;
    }
    
    /**
     * getBreadcum function ini untuk mendapatkan
     * detail menu dari menu (url) saat ini
     * 
     *
     * @param  mixed $request berisi paramater url saat ini
     * @return void
     */
    public function getBreadcum($request)
    {
        return $this->DashboardInterfaces->GetMenuByUrl($request);
    }

    public function data($request)
    {
        $request->merge([
            "month_name" => date("m", strtotime($request->month_name))
        ]);
        return $data = [
            "koperasi_member" => $this->DashboardInterfaces->getTotalMember(),
            "koperasi_order_member" => $this->DashboardInterfaces->getTotalOrderMember($request),
            "koperasi_order_status" => $this->DashboardInterfaces->getTotalOrderStatus($request),
            "top_spender_t_m" => $this->DashboardInterfaces->top_spender_t_m($request),
            "top_spender_m_2" => $this->DashboardInterfaces->top_spender_m_2($request),
            "top_spender_m_1" => $this->DashboardInterfaces->top_spender_m_1($request),
            "most_order" => $this->DashboardInterfaces->most_order($request),
            "brand_rank" => $this->DashboardInterfaces->brand_rank($request)
        ];
    }

    public function banner()
    {
        return $this->BannerInterfaces->getAllData();
    }
}