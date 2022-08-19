<?php

namespace App\Repository\Resignation\Approve\Interfaces;

interface ApproveInterfaces 
{
    public function getData();

    public function UpdateApproval($request);

    public function getDetailResign($id);

    public function gedDataForClearance($request);
}