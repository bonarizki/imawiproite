<?php

namespace App\Repository\Training\Report\Interfaces;

interface TrainingReportInterfaces 
{
    public function ReportTopic($request);

    public function ReportParticipant($request);

    public function ReportMandays($request);

    public function ReportExpanse($request);

    public function ReportFeedback($request);

    public function ReportExpanseLevel($request);
}