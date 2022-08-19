<?php

namespace App\Services\Ticketing;

use App\Events\Ticketing\SendMailRequestCRA;
use App\Repository\Ticketing\Approve\Interfaces\ApproveInterfaces;
use App\Helper\HelperService;
use Auth;
use Illuminate\Support\Carbon;
use App\Events\Ticketing\SendMailRequestPO;
use App\Events\Ticketing\SendMailRequestUser;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Repository\Ticketing\TicketingStatus\Interfaces\TicketingStatusInterfaces;

class ApproveService
{
    private $ApproveInterfaces, $HelperService, $TicketingStatusInterfaces;

    public function __construct(ApproveInterfaces $ApproveInterfaces, HelperService $HelperService, TicketingStatusInterfaces $TicketingStatusInterfaces)
    {
        $this->ApproveInterfaces = $ApproveInterfaces;
        $this->HelperService = $HelperService;
        $this->TicketingStatusInterfaces = $TicketingStatusInterfaces;
    }

    public function getDataApproval()
    {
        $user_nik = Auth::user()->user_nik;
        $data = $this->ApproveInterfaces->getDataApproval($user_nik);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function update($request)
    {
        $ticketing = $this->ApproveInterfaces->getTicketingApporval($request->ticket_id); //mendapatkan data ticketing approval menggunakan id ticketing

        $fieldUpdate = $this->searchField($ticketing); // mendapatkan nama field yang akan di upadate

        $this->fieldUpdate($fieldUpdate, $request);

        $request->merge([
            'ticketing_approval_id' => $ticketing->ticketing_approval_id,
        ]);

        // membuat request header baru untuk update
        $NewRequest = \Helper::instance()->makeRequest([
            "ticket_status" => $request->type,
            "ticket_id" => $request->ticket_id
        ]); 
        $NewRequest = $this->HelperService->addAuthUpdate($NewRequest);

        //proses custome request header
        if ($request->type == 'process' && Auth::user()->user_nik == '72231706') {
            $NewRequest->merge([
                "ticket_status" => 'approve',
            ]);
        }

        $this->UpdateApproval($request);
        $this->ApproveInterfaces->updateStatusHeader($NewRequest);
    }

    public function UpdateApproval($request)
    {
        $type = $request->type;
        $request->request->remove('type');
        $request->request->remove('note');
        DB::transaction(function () use ($request,$type) {
            $this->ApproveInterfaces->approvePo($request);
            $detail_data = $this->TicketingStatusInterfaces->GetDetailTicketing($request->ticket_id);
            $header = $this->ApproveInterfaces->getHeader($request->ticket_id);
            // dd($header);
            if ($type != 'reject') {
                if ($header->type_id == 8) {
                    try {
                        event(new SendMailRequestPO($header, $detail_data, Auth::user()->user_nik));
                    } catch (\Throwable $th) {
                        throw new Exception("Can't Send Email");
                    }
                    
                }else if($header->type_id == 6) {
                    try {
                        event(new SendMailRequestUser($header,$detail_data,Auth::user()->user_nik));
                    } catch (\Throwable $th) {
                        throw new Exception("Can't Send Email");
                    }
                }else if($header->type_id == 10) {
                    try {
                        event(new SendMailRequestCRA($header,$detail_data,Auth::user()->user_nik));
                    } catch (\Throwable $th) {
                        throw new Exception("Can't Send Email");
                    }
                }
            }
        });
    }

    /**
     * searchField
     * di gunakan untuk mendapatk field mana yang akan di update
     *
     * @param  mixed $ticketing adalah data ticketing approval
     * @return void
     */
    public function searchField($ticketing)
    {
        $fieldName = [];

        for ($i = 1; $i <= 8; $i++) {
            $ticketing_approval = "ticketing_approval_nik_";

            if ($i == 7) {
                $ticketing_approval .= 'it1';
            } elseif ($i == 8) {
                $ticketing_approval .= 'it2';
            } else {
                $ticketing_approval .= $i;
            }

            if ($ticketing->$ticketing_approval == Auth::user()->user_nik) {
                $fieldName = array_merge([$ticketing_approval], $fieldName);
            }
        }
        return $fieldName;
    }

    /**
     * fieldUpdate
     *
     * @param  mixed $fieldUpdate adalah nama field yang akan di update dalam bentuk array
     * @param  mixed $request
     * @return void
     */
    public function fieldUpdate($fieldUpdate, $request)
    {
        foreach ($fieldUpdate as $item) {
            $request->merge([
                $item . '_date' => Carbon::now(),
                $item . '_note' => $request->note
            ]);
        }

        return $request;
    }
}
