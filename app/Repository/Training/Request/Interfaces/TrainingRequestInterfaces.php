<?php

namespace App\Repository\Training\Request\Interfaces;

interface TrainingRequestInterfaces
{
    public static function getLastId();

    public static function CreateRequest($request);

    public static function CreateParticipant($participant); // $participant is array

    public static function insertUpdateApproval($data);

    public static function getPartipantByIdTraining($training_id);

    public static function GetApprovalRequest($training_id);

    public static function getDetailTraining($training_id);

    public static function update($request);

    public static function deleteTrainingParticipant($id);

    public static function insertParticipant($request);

}