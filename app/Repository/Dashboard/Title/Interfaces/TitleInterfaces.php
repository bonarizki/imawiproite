<?php

namespace App\Repository\Dashboard\Title\Interfaces;

interface TitleInterfaces
{
    public function getAllTitle();

    public static function getTitleById($id);

    public function updateTitle($request);

    public function deleteTitle($request);

    public function insertTitle($request);

    public function getDataByName($nama);
}