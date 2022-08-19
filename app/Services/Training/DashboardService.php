<?php

namespace App\Services\Training;

use App\Repository\Training\Dashboard\Interfaces\DashboardInterfaces;
use App\Helper\HelperService;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use App\Jobs\Training\ReminderFeedbackJob AS Reminder;
class DashboardService
{
    private $DashboardInterfaces,$HelperService,$UserInterfaces;

    public function __construct(DashboardInterfaces $DashboardInterfaces,HelperService $HelperService, UserInterfaces $UserInterfaces)
    {
        $this->DashboardInterfaces = $DashboardInterfaces;
        $this->HelperService = $HelperService;
        $this->UserInterfaces = $UserInterfaces;
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
    
    /**
     * getAllData function ini untuk membentuk array
     * dimana didalam array tersebut sudah berisi
     * data untuk report - report di dashboard
     *
     * @param  mixed $period_id paramater yang dikirimkan dari controller (id period)
     * @return void
     */
    public function getAllData($period_id)
    {
        $data = [
            "information" => [
                "training_request" => $this->DashboardInterfaces->getTotalRequest($period_id),
                "waiting_approval" => $this->DashboardInterfaces->getInprogress($period_id),
                "feedback" => $this->DashboardInterfaces->getPartipantFeedbackNull($period_id),
                "reject_cancel" => $this->DashboardInterfaces->getRejectCancel($period_id),
                "approve" => $this->DashboardInterfaces->getApprove($period_id),
                "complete" => $this->DashboardInterfaces->getPartipantFeedback($period_id),
            ],
            "information_level" => $this->DashboardInterfaces->getLevelRequest($period_id),
            "information_piechart" => [
                "department" => $this->DashboardInterfaces->getDepartmentRequest($period_id),
                "category" => $this->DashboardInterfaces->getCategoryRequest($period_id),
            ]
        ];

        return $data;
    }
    
    /**
     * feedbackParticipantNull function ini untuk mendapatkan
     * detail participant yang belum mengisi feedback berdasarkan
     * periode yang dipilih
     *
     * @param  mixed $period_id paramater yang dikirimkan dari controller (id period)
     * @return void
     */
    public function feedbackParticipantNull($period_id)
    {
        $data = $this->DashboardInterfaces->getFeedbackNUll($period_id);
        return $this->HelperService->DataTablesResponse($data);
    }
    
    /**
     * feedbackParticipan function ini untuk mendapatkan
     * detail participant yang sudah mengisi feedback berdasarkan
     * periode yang dipilih
     *
     * @param  mixed $period_id paramater yang dikirimkan dari controller (id period)
     * @return void
     */
    public function feedbackParticipan($period_id)
    {
        $data = $this->DashboardInterfaces->getFeedback($period_id);
        return $this->HelperService->DataTablesResponse($data);
    }
    
    /**
     * remindParticipant 
     *
     * @param  mixed $request
     * @return void
     */
    public function remindParticipant($request)
    {
        $request->request->remove('table_length'); // delete table length
        
        foreach ($request->user_remind as $item) {
            $explode = explode('-',$item);
            $detail = $this->DashboardInterfaces->getDetailParticipant($explode[0],$explode[1]);
            Reminder::dispatch($detail);
        }

        return "Remind Success";
    }
}