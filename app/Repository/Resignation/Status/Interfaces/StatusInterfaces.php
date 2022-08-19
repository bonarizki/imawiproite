<?php

namespace App\Repository\Resignation\Status\Interfaces;

interface StatusInterfaces
{
    public function geDataAllProceed($request);

    public function geDataAllUnproceed($request);

    public function cancelResign($request);

    public function insertFeedback($request);

    public function DetailFeedbackPersonal($resign_id);
}