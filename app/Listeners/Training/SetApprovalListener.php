<?php

namespace App\Listeners\Training;

use App\Events\Training\SetApprovalEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repository\Dashboard\ApprovalMatrix\Interfaces\ApprovalMatrixInterfaces;
use App\Repository\Training\Request\Interfaces\TrainingRequestInterfaces as TrainingInterfaces;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;



class SetApprovalListener
{
    private $ApprovalMatrixInterfaces;
    private $TrainingInterfaces;
    private $UserInterfaces;
    
    /**
     * __construct Create the event listener
     *
     * @param  mixed $ApprovalMatrixInterfaces adalah interface dari approvalmatrix
     * @param  mixed $TrainingInterfaces adalah interface dari training
     * @return void
     */
    public function __construct(
        ApprovalMatrixInterfaces $ApprovalMatrixInterfaces, 
        TrainingInterfaces $TrainingInterfaces, 
        UserInterfaces $UserInterfaces)
    {
        $this->ApprovalMatrixInterfaces = $ApprovalMatrixInterfaces;
        $this->TrainingInterfaces = $TrainingInterfaces;
        $this->UserInterfaces = $UserInterfaces;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SetApprovalEvent $event)
    {
        $data = $event->data;
        $dataApproval = $this->prosesCreateArrayApproval($data);
        $this->insertApproval($dataApproval);
    }
    
    /**
     * prosesCreateArrayApproval
     *
     * @param $data adalah data array yang di buat pada service
     * @return void mengembalikan array yang telah dilengkapi dengan approval matrix
     */
    public function prosesCreateArrayApproval($data)
    {
        /** $arr index array same as field database name */
        $nik_ceo = $data->training_fee >= 5000000 ? '75101908' : null;
        $arr = [
            "training_requester_nik" => Auth::user()->user_nik,
            "training_approval_nik_1" => Null,
            "training_approval_nik_2" => Null,
            "training_approval_nik_3" => Null,
            "training_approval_nik_4" => Null,
            "training_approval_nik_5" => Null,
            "training_approval_nik_6" => Null,
            "training_approval_nik_hr" => '45121101',
            "training_approval_nik_ceo" => $nik_ceo,
            "training_id" => $data->training_id,
            "created_by" => Auth::user()->user_name,
            "updated_by" => Auth::user()->user_name,
        ];

        $data = $this->ApprovalMatrixInterfaces->getApprovalByNik(Auth::user()->user_nik);
        if ($data == null) {
            throw new ModelNotFoundException('Email User Not Found');
        }else{
            $arr = $this->addApprovalNik($arr, $data);
        }

        return $arr;
    }
    
    /**
     * addApprovalNik
     *
     * @param  mixed $item adalah array yang sudah dibentuk untuk approval matrix
     * @param  mixed $data adalah data hasil query
     * @return void
     */
    public function addApprovalNik($item, $data)
    {
        $array = [
            "approval_nik_1",
            "approval_nik_2",
            "approval_nik_3",
            "approval_nik_4",
            "approval_nik_5",
            "approval_nik_6",
            "approval_nik_hr",
        ];

        foreach ($array as $key) {
            $NKey = 'training_' . $key;
            //melakukan proses set nilai approval jika tidak null
            if (isset($data->$key)) {
                $item[$NKey] = $data->$key;
            }
        }
        return $item;
    }

    public function insertApproval($data)
    {
        DB::transaction(function () use($data) {
            $this->TrainingInterfaces->insertUpdateApproval($data);
        });
    }
}
