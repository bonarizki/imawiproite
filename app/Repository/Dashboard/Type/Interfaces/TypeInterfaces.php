<?php

namespace App\Repository\Dashboard\Type\Interfaces;

interface TypeInterfaces
{
    public function getAllType();

    public function getTypeById($id);

    public function updateType($request);

    public function deleteType($request);

    public function insertType($request);

    public function getDataByName($name);
}