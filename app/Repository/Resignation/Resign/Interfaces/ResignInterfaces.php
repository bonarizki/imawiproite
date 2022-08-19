<?php

namespace App\Repository\Resignation\Resign\Interfaces;

interface ResignInterfaces
{

    public function getUser($request);

    public function insertResign($request);

    public function DataApprovalMatrix($user_nik);

    public function getLastId();

    public function updateResign($request);
}