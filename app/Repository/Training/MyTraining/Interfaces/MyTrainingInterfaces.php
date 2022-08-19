<?php

namespace App\Repository\Training\MyTraining\Interfaces;

interface MyTrainingInterfaces
{
    public static function getMyTraining($user_nik);

    public static function getDetailParticipant($training_id,$user_nik);

    public static function insertFeedback($request);
}