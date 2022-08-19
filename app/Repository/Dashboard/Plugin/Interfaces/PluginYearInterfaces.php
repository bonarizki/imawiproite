<?php

namespace App\Repository\Dashboard\Plugin\Interfaces;

interface PluginYearInterfaces
{
    public function getDataAllYear($request);

    public function getAllPluginYearActive();

    public function getPluginYearById($id);

    public function updatePluginYear($request);

    public function insertPluginYear($request);
    
    public function deletePluginYear($request);
}