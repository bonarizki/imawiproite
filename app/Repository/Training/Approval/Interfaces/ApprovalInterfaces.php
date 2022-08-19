<?php

namespace App\Repository\Training\Approval\Interfaces;

interface ApprovalInterfaces
{
    public static function getDataApproval($user_nik);

    public static function approveTraining($request);

    public static function getTrainingApproval($training_id);

    public static function rejectTraining($request);

    public static function UpdateApproval($request);
}
