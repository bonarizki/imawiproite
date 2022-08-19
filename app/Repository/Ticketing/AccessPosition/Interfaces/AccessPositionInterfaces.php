<?php

namespace App\Repository\Ticketing\AccessPosition\Interfaces;

interface AccessPositionInterfaces 
{
    public function getData();

    public function detailAccessPosition($id);

    public function updateAccessPosition($request);
}
