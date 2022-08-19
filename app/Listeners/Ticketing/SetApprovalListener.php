<?php

namespace App\Listeners\Ticketing;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repository\Dashboard\ApprovalMatrix\Interfaces\ApprovalMatrixInterfaces;
use App\Events\Ticketing\SetApprovalEvent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Repository\Ticketing\RequestTicketing\Interfaces\RequestTicketingInterfaces;
use Illuminate\Support\Facades\DB;
use App\Repository\Ticketing\SystemApplications\Interfaces\SystemApplicationsInterfaces;


class SetApprovalListener
{
    private $ApprovalMatrixInterfaces;
    private $RequestTicketingInterfaces;
    private $SystemApplicationsInterfaces;
    private $IT1;
    private $IT2;
    
    /**
     * __construct Create the event listener
     *
     * @param  mixed $ApprovalMatrixInterfaces adalah interface dari approvalmatrix
     * @param  mixed $TrainingInterfaces adalah interface dari training
     * @return void
     */
    public function __construct(ApprovalMatrixInterfaces $ApprovalMatrixInterfaces, RequestTicketingInterfaces $RequestTicketingInterfaces, SystemApplicationsInterfaces $SystemApplicationsInterfaces)
    {
        $this->ApprovalMatrixInterfaces = $ApprovalMatrixInterfaces;
        $this->RequestTicketingInterfaces = $RequestTicketingInterfaces;
        $this->SystemApplicationsInterfaces = $SystemApplicationsInterfaces;
        $this->IT1 = '36220903';
        $this->IT2 = '72231706';
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
        $arr = $this->chooseArrayByType($data);
        $approval = $this->ApprovalMatrixInterfaces->getApprovalByNik(Auth::user()->user_nik);
        if ($approval == null) {
            throw new ModelNotFoundException('Email User Not Found');
        }else{
            $arr = $this->addApprovalNik($arr, $approval, $data);
        }
        return $arr;
    }
    
    /**
     * addApprovalNik
     *
     * @param  mixed $item adalah array yang sudah dibentuk untuk approval matrix
     * @param  mixed $apprvoal adalah data hasil query (approval user)
     * @return void
     */
    public function addApprovalNik($item, $approval, $data)
    {
        $array = [
            "approval_nik_1",
            "approval_nik_2",
            "approval_nik_3",
            "approval_nik_4",
            "approval_nik_5",
            "approval_nik_6",
            // "approval_nik_hr",  //sementara karena hr head tidak ada
        ];

        for ($i=0; $i < count($array) ; $i++) { 
            $key = $array[$i];
            $NKey = 'ticketing_' . $key;
            //melakukan proses set nilai approval jika tidak null
            if (isset($approval->$key)) {
                if ($data->type_id == 8 || $data->type_id == 6) {
                    if ($approval->$key != $this->IT1 && $approval->$key != $this->IT2 && $approval->$key != '75101908') {
                        //kondisi untuk team marketing tambahkan nik 34080808 sebelum 73661807
                        if (Auth::user()->department_id == 7 && $approval->$key == '73661807') { 
                            $item[$NKey] = '34080808'; 
                            $NKey = 'ticketing_' . (string) $array[$i+1];
                        }
                        $item[$NKey] = $approval->$key;
                    }

                }else if($data->type_id == 10) {
                    $item[$NKey] = $approval->$key;
                }
            }

        }
        return $item;
    }

    public function insertApproval($data)
    {
        DB::transaction(function () use($data) {
            $this->RequestTicketingInterfaces->insertApproval($data);
        });
    }

    public function chooseArrayByType($data)
    {
        if ($data->type_id == 10) {
            $arr = [
                "ticketing_requester_nik" => Auth::user()->user_nik,
                "ticketing_approval_nik_1" => Null,
                "ticketing_approval_nik_2" => Null,
                "ticketing_approval_nik_3" => Null,
                "ticketing_approval_nik_4" => Null,
                "ticketing_approval_nik_5" => Null,
                "ticketing_approval_nik_6" => Null,
                "ticketing_approval_nik_it1" => Null,
                "ticketing_approval_nik_it2" => $this->SystemApplicationsInterfaces->getPIC($data->other_information)->system_pic_nik, // mendapatkan nik pic user dari master system  application
                "ticket_id" => $data->ticket_id,
                "created_by" => Auth::user()->user_name,
                "updated_by" => Auth::user()->user_name,
            ];
        }else{
            /** $arr index array same as field database name */
            $arr = [
                "ticketing_requester_nik" => Auth::user()->user_nik,
                "ticketing_approval_nik_1" => Null,
                "ticketing_approval_nik_2" => Null,
                "ticketing_approval_nik_3" => Null,
                "ticketing_approval_nik_4" => Null,
                "ticketing_approval_nik_5" => Null,
                "ticketing_approval_nik_6" => Null,
                "ticketing_approval_nik_it1" => $this->IT1,
                "ticketing_approval_nik_it2" => $this->IT2,
                "ticket_id" => $data->ticket_id,
                "created_by" => Auth::user()->user_name,
                "updated_by" => Auth::user()->user_name,
            ];
        }
        return $arr;
    }
}
