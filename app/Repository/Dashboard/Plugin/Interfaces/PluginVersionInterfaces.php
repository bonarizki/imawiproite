<?php

namespace App\Repository\Dashboard\Plugin\Interfaces;

interface PluginVersionInterfaces
{
    public function getAllPluginVersion($request);

    public function getPluginVersionId($id);

    public function updatePluginVersionId($request);

    public function insertPluginVersion($request);

    public function deletePluginVersion($request);

}