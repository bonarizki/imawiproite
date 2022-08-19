<?php

namespace App\Services\Training;

use App\Repository\Training\TrainingMethod\Interfaces\TrainingMethodInterfaces;
use App\Helper\HelperService;

class TrainingMethodService
{
    public $TrainingMethodInterfaces;
    public $HelperService;

    public function __construct(TrainingMethodInterfaces $TrainingMethodInterfaces,HelperService $HelperService)
    {
        $this->TrainingMethodInterfaces = $TrainingMethodInterfaces;
        $this->HelperService = $HelperService;
    }

    public function show()
    {
        $data = $this->TrainingMethodInterfaces->getData();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function create($request)
    {
        $request = $this->HelperService->addAuthInsert($request);
        return $this->TrainingMethodInterfaces->insert($request);
    }

    public function detail ($id)
    {
        return $this->TrainingMethodInterfaces->getDetail($id);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->TrainingMethodInterfaces->update($request);
    }

    public function destroy($request)
    {
        return $this->TrainingMethodInterfaces->destroy($request);
    }
}