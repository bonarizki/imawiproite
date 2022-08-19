<?php

namespace App\Repository\Training\Status\Interfaces;

interface TrainingStatusInterfaces {
    
    public static function GetTrainingProceed($request); // semua data training dengan status approve dan in_progress

    public static function GetDetailTraining($id); // detail trainin

    public static function GetTrainingUnproceed($request); // semua data training dengan status reject dan cancel

    public static function CancelTraining($request); // cancel training

    public static function GetAllTraining($period_id); // semua data training berdasarkan periode id

}