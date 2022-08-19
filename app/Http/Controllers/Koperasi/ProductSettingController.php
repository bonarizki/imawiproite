<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Koperasi\ProductSettingService as SettingService;
use App\Http\Requests\Koperasi\ProductSettingRequest;
use App\Services\Koperasi\ProductService;


class ProductSettingController extends Controller
{
    public $SettingService, $ProductService;

    public function __construct(SettingService $SettingService, ProductService $ProductService)
    {
        $this->SettingService = $SettingService;
        $this->ProductService = $ProductService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->SettingService->ProductBlackList($request);
        }

        $brand = $this->ProductService->getBrandProduct();

        return view('koperasi/productSetting', compact('brand'));
    }

    public function store(ProductSettingRequest $request)
    {
        $this->SettingService->handle($request);
        return \Response::success(["status" => "success", "message" => "Product Setting Updated"]);
    }
}
