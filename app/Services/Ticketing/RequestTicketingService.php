<?php

namespace App\Services\Ticketing;

use App\Repository\Ticketing\RequestTicketing\Interfaces\RequestTicketingInterfaces;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\Ticketing\SendMailRequestPO;
use App\Events\Ticketing\SendMailRequestUser;
use App\Events\Ticketing\SendMailRequestCRA;
use App\Events\Ticketing\SetApprovalEvent;
use App\Helper\HelperService;
use Exception;
use App\Repository\Ticketing\TicketingStatus\Interfaces\TicketingStatusInterfaces;

class RequestTicketingService
{
    public $RequestTicketingInterfaces, $HelperService,$path,$TicketingStatusInterfaces;

    public function __construct(RequestTicketingInterfaces $RequestTicketingInterfaces, HelperService $HelperService, TicketingStatusInterfaces $TicketingStatusInterfaces)
    {
        $this->RequestTicketingInterfaces = $RequestTicketingInterfaces;
        $this->HelperService = $HelperService;
        $this->TicketingStatusInterfaces = $TicketingStatusInterfaces;

        $this->path = public_path('file_uploads/ticketing/request');
    }

    public function store($request)
    {
        DB::transaction(function () use ($request) {
            $array_file_name = null;
            $other_information = null;

            if ($request->file_upload != null) :
                $array_file_name = $this->uploadFile($request->file_upload);
                $array_file_name = implode(',',$array_file_name);
            endif;

            if ($request->user_for != null) :
                $other_information = implode(',',$request->user_for);
            endif;

            if ($request->application_for != null) :
                $other_information = $request->application_for;
            endif;

            $header_data = [
                "ticket_id" => $this->setUpId(),
                "type_id" => $request->type_id,
                "period_id" => $this->HelperService->getIdPriodNow(),
                "user_ticketing_request" => Auth::user()->user_nik,
                "created_by" => Auth::user()->user_name,
                "updated_by" => Auth::user()->user_name,
                "file_name_request" => $array_file_name,
                "reason" => $request->reason,
                "other_information" => $other_information,
                "description" => isset($request->description) ? $request->description : null,
                "request_type" => isset($request->request_type) ? $request->request_type : null
            ];

            $header = $this->RequestTicketingInterfaces->createHeader($header_data);

            $this->storeDetail($request,$header_data,$header);
        });
    }

    public function setUpId()
    {
        $id = $this->RequestTicketingInterfaces->getLastId();
        if ($id == null) {
            $newID = sprintf("%02s", 1) . "/" . date("my") . "TCK";
        } else {
            $explode = explode("/", $id->ticket_id);
            $newID = sprintf("%02s", $explode[0] + 1) . "/" . date("my") . "TCK";
        }
        return $newID;
    }

    public function arrayDetailPo($request, $header)
    {
        $nama_barang = $request->nama_barang;
        $sub_category_id = $request->sub_category_id;
        $qty = $request->qty;
        $harga = $request->harga;
        $data = [];

        for ($i = 0; $i < count($nama_barang); $i++) {
            if (isset($request->accept_user[$i])) {
                $accept_user = $request->accept_user[$i] == 'on' ? 1 : 0 ;
            }else{
                $accept_user = 0;
            }

            $data[] = [
                "nama_barang" => $nama_barang[$i],
                "qty" => $qty[$i],
                "harga" => str_replace('.', '', str_replace('Rp. ', '', $harga[$i])),
                "created_by" => Auth::user()->user_name,
                "updated_by" => Auth::user()->user_name,
                "ticket_id" => $header->ticket_id,
                "sub_category_id" => $sub_category_id[$i],
                "accept_user" =>  $accept_user
            ];
        }

        return $data;
    }
    
    /**
     * uploadFile
     *
     * @param  mixed $file array file
     * @return void mengembalikan nama file yang diupload
     */
    public function uploadFile($file)
    {
        $array_file_name = [];
        foreach ($file as $item) {
            $item->move($this->path,$item->getClientOriginalName()); // proses upload file to folder server
            array_push($array_file_name,$item->getClientOriginalName());
        }
        return $array_file_name;
    }

    public function storeDetail($request,$header_data,$header)
    {
        if ($request->type_id == 8) { // detail ticket it po
            $detail_data = $this->arrayDetailPo($request, $header);
            $this->RequestTicketingInterfaces->insertDetailPo($detail_data);
            $detail = $this->TicketingStatusInterfaces->GetDetailTicketing($header_data['ticket_id']);
            // dd($detail);
            try {
                event(new SetApprovalEvent($header));
            } catch (\Throwable $th) {
                throw new Exception("Can't Set Approval");
            }

            try {
                event(new SendMailRequestPO($header,$detail,Auth::user()->user_nik));
            } catch (\Throwable $th) {
                throw new Exception("Can't Send Email");
            }
        }elseif ($request->type_id == 6) { // detail ticket request user
            $detail_data = $this->arrayDetailReqUser($request,$header);
            $this->RequestTicketingInterfaces->insertDetailRequestUser($detail_data);
            $detail = $this->TicketingStatusInterfaces->GetDetailTicketing($header_data['ticket_id']);
            try {
                event(new SetApprovalEvent($header));
            } catch (\Throwable $th) {
                throw new Exception("Can't Set Approval");
            }

            try {
                event(new SendMailRequestUser($header,$detail,Auth::user()->user_nik));
            } catch (\Throwable $th) {
                throw new Exception("Can't Send Email");
            }
        }elseif ($request->type_id == 10) { // detail ticket cra
            $detail_data = [
                "created_by" => Auth::user()->user_name,
                "updated_by" => Auth::user()->user_name,
                "ticket_id" => $header->ticket_id,
            ];
            $detail_data = \Helper::instance()->MakeRequest($detail_data);
            $this->RequestTicketingInterfaces->insertDetailRequestCRA($detail_data);
            $detail = $this->TicketingStatusInterfaces->GetDetailTicketing($header_data['ticket_id']);

            try {
                event(new SetApprovalEvent($header));
            } catch (\Throwable $th) {
                throw new Exception("Can't Set Approval");
            }

            // try {
                event(new SendMailRequestCRA($header,$detail,Auth::user()->user_nik));
            // } catch (\Throwable $th) {
            //     throw new Exception("Can't Send Email");
            // }
        }
    }

    public function DetailReqCRA($request,$header) 
    {
            $data = [
                "user_nik" => $user_nik[$i],
                "created_by" => Auth::user()->user_name,
                "updated_by" => Auth::user()->user_name,
                "ticket_id" => $header->ticket_id,
            ];
    }

    public function arrayDetailReqUser($request,$header)
    {
        $user_nik = $request->user_nik;
        $data = [];
        for ($i=0; $i < count($user_nik) ; $i++) { 
            $data[] = [
                "user_nik" => $user_nik[$i],
                "created_by" => Auth::user()->user_name,
                "updated_by" => Auth::user()->user_name,
                "ticket_id" => $header->ticket_id,
            ];
        }
        return $data;
    }
}
