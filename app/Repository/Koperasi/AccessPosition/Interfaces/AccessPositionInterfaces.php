<?php

namespace App\Repository\Koperasi\AccessPosition\Interfaces;

interface AccessPositionInterfaces 
{
    public function getData();

    public function detailAccessPosition($id);

    public function updateAccessPosition($request);
}
