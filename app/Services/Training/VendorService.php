<?php

namespace App\Services\Training;

use Illuminate\Support\Facades\Auth;
use App\Helper\HelperService;
use App\Repository\Training\Vendor\Interfaces\VendorInterfaces;
use App\Imports\Training\VendorUpload;
use App\Exports\Training\Vendor;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class VendorService
{
    private $HelperService;
    private $VendorInterfaces;
    private $image_name;
    private $path;

    public function __construct(HelperService $helper, VendorInterfaces $VendorInterfaces)
    {
        $this->HelperService = $helper;
        $this->VendorInterfaces = $VendorInterfaces;
        $this->image_name = [
            "vendor_bank_image",
            "vendor_npwp_image",
            "vendor_siup_image",
            "vendor_tdp_image",
        ];
        $this->path = public_path('file_uploads/images/vendor_data');
    }

    public function show()
    {
        $data = $this->VendorInterfaces->getAllData();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function create ($request)
    {
        $request = $this->HelperService->addAuthInsert($request); //menambah kan auth user untuk update dan create
        $arrReq = $this->handleUpload($request);
        $NewRequest = \Helper::instance()->MakeRequest($arrReq); // merubah array request menjadi object
        return $this->VendorInterfaces->insert($NewRequest);
    }

    public function handleUpload($request)
    {
        $arrReq = $request->toArray(); //membuat reques menjadi array
        $image_name = $this->image_name;
        for ($i=0; $i < count($image_name); $i++) { 
            $file = $request->file($image_name[$i]);
            if ($file != null) {
                $file->move($this->path,$file->getClientOriginalName()); // proses upload file to folder server
                $arrReq[$image_name[$i]] = $file->getClientOriginalName(); // melakukna penggantian dari data file menjadi nama file
            }else{
                $arrReq[$image_name[$i]] = NULL;
            }
        }
        return $arrReq;
    }

    public function detail ($id)
    {
        return $this->VendorInterfaces->getDetail($id);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        $arrReq = $this->handleUpload($request);
        $NewRequest = \Helper::instance()->MakeRequest($arrReq); // merubah array request menjadi object
        return $this->VendorInterfaces->update($NewRequest);
    }

    public function destroy($request)
    {
        return $this->VendorInterfaces->destroy($request);
    }

    public function getVendorByType($request)
    {
        return $this->VendorInterfaces->getBytype($request->vendor_type);
    }

    public function upload($request)
    {
        $import = new VendorUpload($this->VendorInterfaces);
        Excel::import($import, $request->file('file'), null, \Maatwebsite\Excel\Excel::XLSX);
        $data = Excel::toArray([], $request->file('file'));
        $rows = (int)$import->rows - 1 ; // dikurang 1 karean headingnya ikut terhitung
        unset($data[0][0]); // dihapus dulu array pertama karena itu header
        // dd($data[0],$import->success,$import->rows - 1,$import->fail);
        return $data = [
            "message"=>"Total Data = {$rows} , 
                        Success Upload = {$import->success}, 
                        Fail Upload = {$import->fail}",
            "dataTable"=>$this->HelperService->DataTablesResponse(($data[0])),
            "detailFail"=>$import->errors
        ];
    }

    public function downloadVendor()
    {
        $data = $this->VendorInterfaces->getAllData();
        return Excel::download(new Vendor($data),'Daftar Vendor.xlsx');
    }

    public function downloadVendorById($id)
    {
        $detail = $this->VendorInterfaces->getDetail($id);
        $title = 'Detail Vendor';
        $pdf = PDF::loadView('training/report/detail_vendor', compact('detail'));
        $pdf->setOptions([
            'enable-local-file-access' => true,
            'enable-javascript' => true,
            'margin-left' => '0mm',
            'margin-right' => '0mm',
            'margin-top' => '40mm',
            'margin-bottom' => '40mm',
            'header-html' => view('report/export_header', compact('title')),
            'header-spacing' => 7,
            'footer-html' => view('report/export_footer'),
            'footer-spacing' => 7,
        ]);

        return $pdf->inline();
    }
}
