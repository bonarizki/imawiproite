<?php

namespace App\Services\Resignation;

use App\Repository\Resignation\Approve\Interfaces\ApproveInterfaces;
use App\Repository\Resignation\Clearance\Interfaces\ClearanceInterfaces;
use App\Repository\Resignation\Status\Interfaces\StatusInterfaces;
use App\Repository\Resignation\Report\Interfaces\ReportInterfaces;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Resignation\feedbackPersonal;
use App\Exports\Resignation\AttritionRate;
use App\Exports\Resignation\AttritionRateTalent;
use App\Exports\Resignation\AttritionRateInitiation;
use App\Exports\Resignation\feedback;
use App\Helper\HelperService;

class ReportService
{
    private $ApproveInterfaces;
    private $ClearanceInterfaces;
    private $StatusInterfaces;
    private $ReportInterfaces;
    private $HelperService;

    public function __construct(ApproveInterfaces $ApproveInterfaces, 
    ClearanceInterfaces $ClearanceInterfaces, 
    StatusInterfaces $StatusInterfaces, 
    ReportInterfaces $ReportInterfaces,
    HelperService $HelperService)
    {
        $this->ApproveInterfaces = $ApproveInterfaces;
        $this->ClearanceInterfaces = $ClearanceInterfaces;
        $this->StatusInterfaces = $StatusInterfaces;
        $this->ReportInterfaces = $ReportInterfaces;
        $this->HelperService = $HelperService;
    }

    public function ReferenceLetter($resign_id)
    {
        $resign_id = str_replace("-", "/", $resign_id); // merubah min to backslash
        $title = 'REFERENCE LETTER';
        $data = $this->ApproveInterfaces->getDetailResign($resign_id); // mendapatkan detail resign 
        $pdf = PDF::loadView('resignation/report/reference_letter', compact('data'));
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

    public function Clearance($resign_id)
    {
        $title = 'Clearance Form';
        $resign_id = str_replace("-", "/", $resign_id); // merubah min to backslash
        $data = $this->ApproveInterfaces->getDetailResign($resign_id); // mendapatkan detail resign 
        $question = $this->ClearanceInterfaces->getQuestionClearance(); // mendapatkan soal
        $data_approval = $this->ClearanceInterfaces->getDetailApprover($resign_id);
        $data_answer = $this->ClearanceInterfaces->getAnswer($resign_id)->clearance_answer; // mendapatkan jawaban berdasarakan id resign
        $answer = (explode("#", $data_answer)); //menglakukan explode
        array_pop($answer); // menghapus array terakhir karena selalu null atau kosong
        $pdf = PDF::loadView('resignation/report/clearance', compact('data', 'answer', 'question', 'data_approval'));
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

    public static function ValidationChecked($value, $answer)
    {
        foreach ($answer as  $item) {
            if ($item == $value) return "checked";
        }
    }

    public function feedbackByID($resign_id)
    {
        $resign_id = str_replace("-", "/", $resign_id); // merubah min to backslash
        return Excel::download(new feedbackPersonal($this->StatusInterfaces, $resign_id), 'feedbackpersonal.xlsx');
    }

    public function remindFeedBack($resign_id)
    {
        $resign_id = str_replace("-", "/", $resign_id); // merubah min to backslash
        return Excel::download(new feedbackPersonal($this->StatusInterfaces, $resign_id), 'feedbackpersonal.xlsx');
    }

    public function getDataForview($request)
    {
        return $this->ReportInterfaces->AtritionRate($request);
    }

    public function ARDownload($request)
    {
        if ($request->type == 'period') :
            $file_name = 'AttritionRate-Period-' . $request->period_name . '.xlsx';
        elseif ($request->type == 'month') :
            $file_name = 'AttritionRate-Month-' . $request->month_name . '-' . $request->year_name . '.xlsx';
        elseif ($request->type == 'quarter') :
            $file_name = 'AttritionRate-Quarter-' . $request->quarter_name . '-' . $request->period_name . '.xlsx';
        endif;
        return Excel::download(new AttritionRate($this->ReportInterfaces, $request), $file_name);
    }

    //Attration Rate Based On Talent
    public function getDataTalentForview($request)
    {
        return $this->ReportInterfaces->ARTalent($request);
    }

    public function ARTalentDownload($request)
    {
        if ($request->type == 'period') :
            $file_name = 'AttritionRateTalent-Period-' . $request->period_name . '.xlsx';
        elseif ($request->type == 'month') :
            $file_name = 'AttritionRateTalent-Month-' . $request->month_name . '-' . $request->year_name . '.xlsx';
        elseif ($request->type == 'quarter') :
            $file_name = 'AttritionRateTalent-Quarter-' . $request->quarter_name . '-' . $request->period_name . '.xlsx';
        endif;
        return Excel::download(new AttritionRateTalent($this->ReportInterfaces, $request), $file_name);
    }

    public function getDataInitiationForview($request)
    {
        return $this->ReportInterfaces->ARInitiation($request);
    }

    public function ARInitiationDownload($request)
    {
        if ($request->type == 'period') :
            $file_name = 'AttritionRateInitiation-Period-' . $request->period_name . '.xlsx';
        elseif ($request->type == 'month') :
            $file_name = 'AttritionRateInitiation-Month-' . $request->month_name . '-' . $request->year_name . '.xlsx';
        elseif ($request->type == 'quarter') :
            $file_name = 'AttritionRateInitiation-Quarter-' . $request->quarter_name . '-' . $request->period_name . '.xlsx';
        endif;
        return Excel::download(new AttritionRateInitiation($this->ReportInterfaces, $request), $file_name);
    }

    public function getDataFeedbackForview($request)
    {
        $data = $this->ReportInterfaces->feedback($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function downloadFeedback($request)
    {
        if ($request->type == 'period') :
            $file_name = 'Feedback-Period-' . $request->period_name . '.xlsx';
        elseif ($request->type == 'month') :
            $file_name = 'Feedback-Month-' . $request->month_name . '-' . $request->year_name . '.xlsx';
        elseif ($request->type == 'quarter') :
            $file_name = 'Feedback-Quarter-' . $request->quarter_name . '-' . $request->period_name . '.xlsx';
        endif;
        return Excel::download(new feedback($this->ReportInterfaces, $request), $file_name);
    }

}
