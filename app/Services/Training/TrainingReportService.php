<?php

namespace App\Services\Training;

use App\Helper\HelperService;
use App\Repository\Training\Status\Interfaces\TrainingStatusInterfaces;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Repository\Training\Report\Interfaces\TrainingReportInterfaces;
use App\Exports\Training\ReportByTopic;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Training\ReportByMandays;
use App\Exports\Training\ReportByParticipant;
use App\Exports\Training\ReportByExpanse;
use App\Exports\Training\ReportByFeedback;
use App\Exports\Training\ReportByExpanseLevel;

class TrainingReportService
{
    private $HelperService;
    private $TrainingStatusInterfaces;
    private $TrainingReportInterfaces;

    public function __construct(
        HelperService $HelperService,
        TrainingStatusInterfaces $TrainingStatusInterfaces,
        TrainingReportInterfaces $TrainingReportInterfaces)
    {
        $this->HelperService = $HelperService;
        $this->TrainingStatusInterfaces = $TrainingStatusInterfaces;
        $this->TrainingReportInterfaces = $TrainingReportInterfaces;
    }

    public function downloadRequest($training_id)
    {
        $title = 'Training Request';
        $training_id = str_replace("-", "/", $training_id); // merubah min to backslash
        $data = $this->TrainingStatusInterfaces->GetDetailTraining($training_id);
        $pdf = PDF::loadView('training/report/RequestTraining', compact('data'));
        $pdf->setOptions([
            'enable-local-file-access' => true,
            'enable-javascript' => true,
            'margin-left' => '0mm',
            'margin-right' => '0mm',
            'margin-top' => '40mm',
            'margin-bottom' => '40mm',
            'header-html' => view('training/report/export_header', compact('title')),
            'header-spacing' => 7,
            'footer-html' => view('training/report/export_footer'),
            'footer-spacing' => 7,
        ]);

        return $pdf->inline();
    }

    public function ViewReportTopic($request)
    {
        $request = $this->SetPeriodId($request);
        $data = $this->TrainingReportInterfaces->ReportTopic($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function downloadReportTopic($request)
    {
        $request = $this->SetPeriodId($request);
        $data = $this->TrainingReportInterfaces->ReportTopic($request);
        if ($request->type == 'period') :
            $file_name = 'TrainingTopic-Period-' . $request->period_name . '.xlsx';
        elseif ($request->type == 'month') :
            $file_name = 'TrainingTopic-Month-' . $request->month_name . '-' . $request->year_name . '.xlsx';
        endif;
        return Excel::download(new ReportByTopic($data),$file_name);
    }

    public function SetPeriodId($request)
    {
        if ($request->type == 'period') 
            $request->merge([
                "period_id" => $this->HelperService->getIdPeriod($request->period_name)
            ]);

        return $request;
    }

    public function ViewReportParticipant($request)
    {
        $data = $this->SetPeriodId($request);
        $data = $this->TrainingReportInterfaces->ReportParticipant($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function DownloadReportParticipant($request)
    {
        $data = $this->SetPeriodId($request);
        $data = $this->TrainingReportInterfaces->ReportParticipant($request);
        if ($request->type == 'period') :
            $file_name = 'TrainingParticipant-Period-' . $request->period_name . '.xlsx';
        elseif ($request->type == 'month') :
            $file_name = 'TrainingParticipant-Month-' . $request->month_name . '-' . $request->year_name . '.xlsx';
        endif;
        return Excel::download(new ReportByParticipant($data),$file_name);
    }

    public function ViewReportFeedback($request)
    {
        $data = $this->SetPeriodId($request);
        $data = $this->TrainingReportInterfaces->ReportFeedback($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function DownloadReportFeedback($request)
    {
        $data = $this->SetPeriodId($request);
        $data = $this->TrainingReportInterfaces->ReportFeedback($request);
        if ($request->type == 'period') :
            $file_name = 'TrainingFeedback-Period-' . $request->period_name . '.xlsx';
        elseif ($request->type == 'month') :
            $file_name = 'TrainingFeedback-Month-' . $request->month_name . '-' . $request->year_name . '.xlsx';
        endif;
        return Excel::download(new ReportByFeedback($data),$file_name);
    }

    public function ViewReportMandays($request)
    {
        $data = $this->TrainingReportInterfaces->ReportMandays($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function DownloadReportMandays($request)
    {
        $data = $this->TrainingReportInterfaces->ReportMandays($request);
        $file_name = 'TrainingMandays-Period-' . $request->period_name . '.xlsx';
        return Excel::download(new ReportByMandays($data),$file_name);
    }

    public function ViewReportExpense($request)
    {
        $data = $this->TrainingReportInterfaces->ReportExpanse($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function DownloadReportExpense($request)
    {
        $data = $this->TrainingReportInterfaces->ReportExpanse($request);
        $file_name = 'TrainingExpense-Period-' . $request->period_name . '.xlsx';
        return Excel::download(new ReportByExpanse($data),$file_name);
    }

    public function ViewReportExpenseLevel($request)
    {
        $data = $this->TrainingReportInterfaces->ReportExpanseLevel($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function DownloadReportExpenseLevel($request)
    {
        $data = $this->TrainingReportInterfaces->ReportExpanseLevel($request);
        $file_name = 'TrainingExpenseLevel-Period-' . $request->period_name . '.xlsx';
        return Excel::download(new ReportByExpanseLevel($data),$file_name);
    }
}

