<?php

namespace App\Repository\Resignation\Report\Interfaces;

interface ReportInterfaces
{
    public function AtritionRate($request);

    public function ARTalent($request);

    public function ARInitiation($request);

    public function feedback($request);

}