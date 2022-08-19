<?php

namespace App\Services\Koperasi;

use App\Repository\Koperasi\Banner\Interfaces\BannerInterfaces;
use App\Helper\HelperService;

class BannerService
{
    public $BannerInterfaces,$HelperService;

    public function __construct(BannerInterfaces $BannerInterfaces,HelperService $HelperService)
    {
        $this->BannerInterfaces = $BannerInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getAllData()
    {
        $data = $this->BannerInterfaces->getAllData();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function store($request)
    {
        
        $this->handleUpload($request);
        $newRequest = \Helper::instance()->MakeRequest([
            "banner_status" => $request->banner_status == null ? "non-active" : "active",
            "banner_image" => $request->file('banner_image')->getClientOriginalName()
        ]);
        $newRequest = $this->HelperService->addAuthInsert($newRequest);
        return $this->BannerInterfaces->addBanner($newRequest);
    }

    public function handleUpload($request)
    {
        if($request->hasfile('banner_image')):
            $file = $request->file('banner_image');
            $file->move(public_path('file_uploads/images/koperasi/banner'),$file->getClientOriginalName());
        endif;
    }

    public function delete($id)
    {
        $newRequest = \Helper::instance()->MakeRequest([
            "banner_id" => $id
        ]);

        return $this->BannerInterfaces->delete($newRequest);
    }

    public function edit($id)
    {
        return $this->BannerInterfaces->edit($id);
    }

    public function update($request)
    {
        $this->handleUpload($request);
        $newRequest = \Helper::instance()->MakeRequest([
            "banner_status" => $request->banner_status == null ? "non-active" : "active",
            "banner_image" => $request->file('banner_image')->getClientOriginalName(),
            "banner_id" => $request->banner_id
        ]);
        $newRequest = $this->HelperService->addAuthUpdate($newRequest);
        return $this->BannerInterfaces->update($newRequest);
    }
}