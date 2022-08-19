<?php

namespace App\Services\Koperasi;

use App\Exports\Koperasi\OrderList;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Helper\HelperService;
use App\Repository\Koperasi\Order\Interfaces\OrderInterfaces;
use Maatwebsite\Excel\Facades\Excel;

class DownloadService
{
    private $HelperService,$OrderInterfaces;

    public function __construct(HelperService $HelperService,OrderInterfaces $OrderInterfaces)
    {
        $this->HelperService = $HelperService;
        $this->OrderInterfaces = $OrderInterfaces;
    }

    public function downloadHistory($id)
    {
        $id = str_replace('.', '/', $id);
        $title = 'PURCHASE ORDER';
        $data = $this->OrderInterfaces->HeaderDetail($id); // mendapatkan detail order
        $pdf = PDF::loadView('koperasi/report/order_detail', compact('data'));
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

    public function downloadOrder($request)
    {
        $data = $this->OrderInterfaces->allOrder($request);
        return Excel::download(new OrderList($data), 'Order List.xlsx');
    }
}
