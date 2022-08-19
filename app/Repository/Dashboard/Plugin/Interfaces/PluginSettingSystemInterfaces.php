<?php

namespace App\Repository\Dashboard\Plugin\Interfaces;

interface PluginSettingSystemInterfaces
{
    public function getAllSystemSetting($request);

    public function getPluginSystemSettingById($id);

    public function updatePluginSystemSettingById($request);

    public function insertPluginSystemSetting($request);

    public function deletePluginSystemSetting($request);
}