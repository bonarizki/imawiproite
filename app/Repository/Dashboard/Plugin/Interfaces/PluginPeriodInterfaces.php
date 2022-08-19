<?php

namespace App\Repository\Dashboard\Plugin\Interfaces;

interface PluginPeriodInterfaces
{
    public function getAllPluginPeriod($request);

    public function getAllPluginPeriodActive();

    public function getPluginPeriodById($id);

    public function updatePluginPeriodById($request);

    public function insertPluginPeriod($request);

    public function deletePluginPeriod($request);

    public function GetPeriodIdUseName($period_name);
}