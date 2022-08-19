<?php

namespace App\Services\Koperasi;

use App\Repository\Koperasi\ProductSetting\Interfaces\ProductSettingInterfaces as SettingInterfaces;
use App\Helper\HelperService;

class ProductSettingService
{
    public $SettingInterfaces,$HelperService;

    public function __construct(SettingInterfaces $SettingInterfaces,HelperService $HelperService)
    {
        $this->HelperService = $HelperService;
        $this->SettingInterfaces = $SettingInterfaces;
    }

    public function ProductBlackList($request)
    {
        $data = $this->SettingInterfaces->ProductBlackList($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function handle($request)
    {
        $data = $this->SettingInterfaces->getSettingByProductCode($request->product_code);
        if (empty($data)) {
            $request = $this->HelperService->addAuthInsert($request);
            return $this->SettingInterfaces->create($request);
        }else{
            $request = $this->HelperService->addAuthUpdate($request);
            $request->merge([
                'product_setting_id' => $data->product_setting_id
            ]);
            return $this->SettingInterfaces->update($request);
        }
    }

}