<?php

namespace App\Repository\Resignation\Clearance\Interfaces;

interface ClearanceInterfaces 
{
    public function getQuestionClearance();

    public function insertClearanceQuestion($request);

    public function DetailClearanceQuestion($id);

    public function updateClearanceQuestion($request);

    public function deleteClearanceQuestion($request);

    public function insertOrUpdateAnswer($request);

    public function getAnswer($resign_id);

    public function getDetailApprover($resign_id);
}