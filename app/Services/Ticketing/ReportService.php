<?php

namespace App\Services\Ticketing;

use App\Repository\Ticketing\TicketingStatus\Interfaces\TicketingStatusInterfaces;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Ticketing\ReportITPO;

class ReportService
{
    public $TicketingStatusInterfaces;

    public function __construct(TicketingStatusInterfaces $TicketingStatusInterfaces)
    {
        $this->TicketingStatusInterfaces = $TicketingStatusInterfaces;
    }

    public function handle($request)
    {
        if ($request->type_id == 8) {
            return $this->getDataReportITPO($request);
        }else{
            return "false";
        }
    }
    public function getDataReportITPO($request)
    {
        $data = $this->TicketingStatusInterfaces->getDataTicket($request, ['approve' , 'done']);
        return DataTables::of($data)
            ->addColumn("lead_time_1" , function ($q){
                if ($q->Approval->ticketing_approval_nik_1_date != null) {
                    return $this->rangeDate($q->created_at, $q->Approval->ticketing_approval_nik_1_date);
                }else{
                    return 0;
                }
                
            })
            ->addColumn("lead_time_2" , function ($q){
                if ($q->Approval->ticketing_approval_nik_2_date != null) {
                    return $this->rangeDate($q->Approval->ticketing_approval_nik_1_date, $q->Approval->ticketing_approval_nik_2_date);
                }else{
                    return 0;
                }
                
            })
            ->addColumn("lead_time_3" , function ($q){
                if ($q->Approval->ticketing_approval_nik_3_date != null) {
                    return $this->rangeDate($q->Approval->ticketing_approval_nik_2_date, $q->Approval->ticketing_approval_nik_3_date);
                }else{
                    return 0;
                }
                
            })
            ->addColumn("lead_time_4" , function ($q){
                if ($q->Approval->ticketing_approval_nik_4_date != null) {
                    return $this->rangeDate($q->Approval->ticketing_approval_nik_3_date, $q->Approval->ticketing_approval_nik_4_date);
                }else{
                    return 0;
                }
                
            })
            ->addColumn("lead_time_5" , function ($q){
                if ($q->Approval->ticketing_approval_nik_5_date != null) {
                    return $this->rangeDate($q->Approval->ticketing_approval_nik_4_date, $q->Approval->ticketing_approval_nik_5_date);
                }else{
                    return 0;
                }
                
            })
            ->addColumn("lead_time_6" , function ($q){
                if ($q->Approval->ticketing_approval_nik_6_date != null) {
                    return $this->rangeDate($q->Approval->ticketing_approval_nik_5_date, $q->Approval->ticketing_approval_nik_6_date);
                }else{
                    return 0;
                }
                
            })
            ->addColumn("lead_time_it1" , function ($q){
                $number_last_approval = $this->chekcApproval($q);
                $approval = "ticketing_approval_nik_".$number_last_approval;
                $approval_date = $approval."_date";
                // dd($q->Approval,$approval,$approval_date);
                if ($q->Approval->$approval != null) {
                    if ($q->Approval->$approval_date != null) {
                        return $this->rangeDate($q->Approval->$approval_date, $q->Approval->ticketing_approval_nik_it1_date);
                    }else{
                        return 0;
                    }
                    
                }else{
                    return 0;
                }
                
            })
            ->addColumn("lead_time_it2" , function ($q){
                if ($q->Approval->ticketing_approval_nik_it2_date != null) {
                    return $this->rangeDate($q->Approval->ticketing_approval_nik_it1_date, $q->Approval->ticketing_approval_nik_it2_date);
                }else{
                    return 0;
                }
                
            })
            ->addColumn("lead_time_done" , function ($q){
                if ($q->ticket_status != 'done') {
                    return 0;
                }else{
                    return $this->rangeDate($q->created_at, $q->updated_at);
                }
                
            })
            ->addColumn("total_lead_time" , function ($q){
                if ($q->ticket_status != 'done') {
                    return $this->rangeDate($q->created_at, $q->Approval->ticketing_approval_nik_it2_date);
                }else{
                    return $this->rangeDate($q->created_at, $q->updated_at);
                }
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function rangeDate($fdate,$ldate)
    {
        $to = \Carbon\Carbon::parse($fdate);
        $from = \Carbon\Carbon::parse($ldate);

        return $to->startOfDay()->diffInDays($from);
    }

    public function chekcApproval($q) // this function is looking for index the last approval 
    {
        $temp = 0;
        for ($i=1; $i <= 6 ; $i++) { 
            $approval =  "ticketing_approval_nik_". $i;
            if ($q->Approval->$approval != null) {
                $temp = $temp + 1;
            }
        }
        return $temp;
    }

    public function chekcApprovalIT1($q)
    {

    }

    public function handleDownload($request)
    {
        if ($request->type_id == 8) {
            $data = $this->getDataReportITPO($request);
            $data =$data->original["data"];
            return Excel::download(new ReportITPO($data), "Report IT PO.xlsx");
        };
    }

    
}