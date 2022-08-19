<?php

namespace App\Services\Ticketing;

use App\Repository\Ticketing\TicketingStatus\Interfaces\TicketingStatusInterfaces;
use App\Exports\Ticketing\ReportAllTicketITPO;
use App\Exports\Ticketing\ReportAllTicketCRA;
use  App\Exports\Ticketing\ReportAllTicketRequestUser;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class DownloadService 
{
    public $TicketingStatusInterfaces, $proceed, $unproceed;

    public function __construct(TicketingStatusInterfaces $TicketingStatusInterfaces)
    {
        $this->TicketingStatusInterfaces = $TicketingStatusInterfaces;
        $this->proceed = ['process', 'done', 'initial', 'approve'];
        $this->unproceed = ['cancel', 'reject'];
    }

    public function handle($request)
    {
        $this->changeIndexRequest($request); // merubah index request agar sesuai dengan index di repository
        return $this->downloadStatus($request);
    }

    public function changeIndexRequest($request)
    {
        $request->merge([
            "department_id" => $request->department_search,
            "ticket_status" => $request->ticket_status_search,
            "period_id" => $request->period_search,
            "type_id" => $request->ticket_type_search
        ]);

        $request->request->remove('department_search');
        $request->request->remove('ticket_status_search');
        $request->request->remove('period_search');
        $request->request->remove('ticket_type_search');
        return $request;
    }

    public function downloadStatus($request)
    {
        $type = $request->type == 'proceed' ? $this->proceed : $this->unproceed;
        $data = $this->TicketingStatusInterfaces->getDataTicket($request, $type );

        if ($request->type_id == 8) {
            $data->load('DetailPo');
            return Excel::download(new ReportAllTicketITPO($data), "$request->type - Request ITPO.xlsx");
        }elseif ($request->type_id == 10) {
            $data->load('DetailRequestCra');
            return Excel::download(new ReportAllTicketCRA($data), "$request->type - Request CRF.xlsx");
        }elseif($request->type_id == 6){
            $data->load('DetailRequestAccessUser');
            return Excel::download(new ReportAllTicketRequestUser($data), "$request->type - Request User.xlsx");
        }else{
            "return no";
        }

    }

    public function downloadPDFById($id)
    {
        $title = 'Request Form IT';
        $ticket_id = str_replace("-", "/", $id); // merubah min to backslash
        $data = $this->TicketingStatusInterfaces->GetDetailTicketing($ticket_id);
        $pdf = PDF::loadView('ticketing/report/reportById', compact('data'));
        $pdf->setOptions([
            'enable-local-file-access' => true,
            'enable-javascript' => true,
            'margin-left' => '0mm',
            'margin-right' => '0mm',
            'margin-top' => '40mm',
            'margin-bottom' => '40mm',
            'header-html' => view('resignation/report/export_header', compact('title')),
            'header-spacing' => 7,
            'footer-html' => view('resignation/report/export_footer'),
            'footer-spacing' => 7,
        ]);

        return $pdf->inline();
    }

    public function downloadRequestAccessUser($id)
    {
        $title = 'Request Form Access User';
        $ticket_id = str_replace("-", "/", $id); // merubah min to backslash
        $data = $this->TicketingStatusInterfaces->GetDetailTicketing($ticket_id);
        $pdf = PDF::loadView('ticketing/report/reportByIdRequestAccessUser', compact('data'));
        $pdf->setOptions([
            'enable-local-file-access' => true,
            'enable-javascript' => true,
            'margin-left' => '0mm',
            'margin-right' => '0mm',
            'margin-top' => '40mm',
            'margin-bottom' => '40mm',
            'header-html' => view('resignation/report/export_header', compact('title')),
            'header-spacing' => 7,
            'footer-html' => view('resignation/report/export_footer'),
            'footer-spacing' => 7,
        ]);

        return $pdf->inline();
    }

    public function downloadRequestCRA($id)
    {
        $title = 'Change Request Form';
        $ticket_id = str_replace("-", "/", $id); // merubah min to backslash
        $data = $this->TicketingStatusInterfaces->GetDetailTicketing($ticket_id);
        // dd($data);
        $pdf = PDF::loadView('ticketing/report/reportByIdRequestCRA', compact('data'));
        $pdf->setOptions([
            'enable-local-file-access' => true,
            'enable-javascript' => true,
            'margin-left' => '0mm',
            'margin-right' => '0mm',
            'margin-top' => '40mm',
            'margin-bottom' => '40mm',
            'header-html' => view('resignation/report/export_header', compact('title')),
            'header-spacing' => 7,
            'footer-html' => view('resignation/report/export_footer'),
            'footer-spacing' => 7,
        ]);

        return $pdf->inline();
    }
}