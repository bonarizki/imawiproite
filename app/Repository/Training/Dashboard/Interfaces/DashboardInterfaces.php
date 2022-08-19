<?php

namespace App\Repository\Training\Dashboard\Interfaces;

interface DashboardInterfaces
{
    public static function GetMenuByUrl($request);

    public static function getTotalRequest($period_id);

    public static function getInprogress($period_id);

    public static function getPartipantFeedbackNull($period_id); // mendapatkan total peserta yang belum mengisi feedback

    public static function getPartipantFeedback($period_id); // mendapatkan total peserta yang sudah mengisi feedback

    public static function getApprove($period_id);

    public static function getRejectCancel($period_id);

    public static function complete($period_id);

    public static function getLevelRequest($period_id);

    public static function getDepartmentRequest($period_id);

    public static function getCategoryRequest($period_id);

    public static function getFeedbackNUll($period_id);

    public static function getFeedback($period_id);

    public static function getDetailParticipant($user_nik,$training_id);

}