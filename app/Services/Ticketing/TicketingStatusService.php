<?php

namespace App\Services\Ticketing;

use App\Repository\Ticketing\TicketingStatus\Interfaces\TicketingStatusInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;
use App\Repository\Ticketing\TicketingType\Interfaces\TicketingTypeInterfaces;
use Yajra\DataTables\DataTables;


class TicketingStatusService
{
    private $TicketingStatusInterfaces, $HelperService, $proceed, $unproceed, $TicketingTypeInterfaces;

    public function __construct(
        TicketingStatusInterfaces $TicketingStatusInterfaces,
        HelperService $HelperService,
        TicketingTypeInterfaces $TicketingTypeInterfaces
    ) {
        $this->TicketingStatusInterfaces = $TicketingStatusInterfaces;
        $this->TicketingTypeInterfaces = $TicketingTypeInterfaces;
        $this->HelperService = $HelperService;
        $this->proceed = ['process', 'done', 'initial', 'approve'];
        $this->unproceed = ['cancel', 'reject'];
    }

    /**
     * TicketingAll semua data training berdasarkan period id dan tanpa training status
     *
     * @return void
     */
    // public function TicketingAll($period_id)
    // {
    //     $data = $this->TicketingStatusInterfaces->GetAllTicketing($period_id);
    //     return $this->HelperService->DataTablesResponse($data);
    // }

    /**
     * TicketingAllData semua data training dengan status in_progress dan approve
     *
     * @param  mixed $request
     * @return void
     */
    public function getTicketingAllData($request)
    {
        $type_id = $this->checkPIC(); //mendapatkan type ticket id bila si user adalah pic dari ticket type tersebut dalam bentuk array
        $data = $this->TicketingStatusInterfaces->getDataTicket($request, $this->proceed);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('edit', function ($r) use ($type_id) {
                if ($type_id->count() > 0) {
                     return in_array($r->type_id, $type_id->toArray()); // mengecek apakah row ini milik pic dari ticket type, jika iya maka true untuk edit, false untuk tidak bisa edit
                } else {
                    return false;
                }
            })
            ->make(true);
    }

    /**
     * TicketingDataById semua data ticketing dengan status in_progress dan done berdasarkan id user
     *
     * @param  mixed $request
     * @return void
     */
    public function getTicketingDataById($request)
    {
        $request->merge([
            'user_nik_auth' => Auth::user()->user_nik
        ]);
        $data = $this->TicketingStatusInterfaces->getDataTicket($request,$this->proceed);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getTicketingStatusID($request)
    {
        return $this->TicketingStatusInterfaces->GetDetailTicketing($request->ticket_id);
    }

    /**
     * getTicketingAllDataUnproceed semua data ticketing dengan status reject dan cancel
     *
     * @param  mixed $request
     * @return void
     */
    public function getTicketingAllDataUnproceed($request)
    {
        $data = $this->TicketingStatusInterfaces->getDataTicket($request,$this->unproceed);
        return $this->HelperService->DataTablesResponse($data);
    }

    /**
     * TrainingDataByIdUnproceed semua data training dengan status reject dan cancel berdasarkan id user
     *
     * @param  mixed $request
     * @return void
     */
    public function getTicketingDataByIdUnproceed($request)
    {
        $request->merge([
            'user_nik_auth' => Auth::user()->user_nik
        ]);
        $data = $this->TicketingStatusInterfaces->getDataTicket($request,$this->unproceed);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function CancelTicketing($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        $request->merge([
            "ticket_status" => "cancel"
        ]);
        return $this->TicketingStatusInterfaces->CancelTicketing($request);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        if ($request->type_id != null) {
            $request->request->remove('type_id');
            $this->TicketingStatusInterfaces->updateDetailTicket($request);
        }else{
            $this->updateStatus($request);
        }

    }

    public function updateStatus($request)
    {
        return $this->TicketingStatusInterfaces->updateStatus($request);
    }

    public function checkPIC()
    {
       return $this->TicketingTypeInterfaces->getTicketTypePIC(Auth::user()->user_nik);
    }

}
