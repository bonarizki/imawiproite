<?php

namespace App\Repository\Dashboard\Plugin\Interfaces;

interface PluginMonthInterfaces
{
    public function getAllPluginMonth($request);

    public function getPluginMonthById($id);

    public function updatePluginMonthId($request);

    public function insertPluginMonth($request);

    public function deletePluginMonth($request);
}