<?php

namespace App\Services\Training;

use App\Repository\Training\Request\Interfaces\TrainingRequestInterfaces as RequestInterfaces;
use App\Helper\HelperService;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\Training\SetApprovalEvent;
use App\Events\Training\SendMailEvent;
use App\Events\Training\SetNullApprovalEvent;
use Exception;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Training\UploadParticipant;

class TrainingRequestService
{
    private $RequestInterfaces;
    private $HelperService;
    private $UserInterfaces;

    public function __construct(RequestInterfaces $RequestInterfaces, HelperService $HelperService, UserInterfaces $UserInterfaces)
    {
        $this->RequestInterfaces = $RequestInterfaces;
        $this->HelperService = $HelperService;
        $this->UserInterfaces = $UserInterfaces;
    }

    public function getParticipant()
    {
        $data_user = $this->UserInterfaces->getUserByNik(Auth::user()->user_nik);
        $grade_group_id = $data_user->Grade->GradeGroup->grade_group_id;
        $department_id = Auth::user()->department_id;
        return $this->UserInterfaces->getUserUnderGradeGroup($department_id, $grade_group_id);
    }

    public function getParticipantAll($request)
    {
        return $this->UserInterfaces->getAllUser($request);
    }

public function createRequest($request)
    {
        /** custom request (split training_date dan training_hour) */
        $this->customRequest($request);

        /** set array untuk insert ke mst_training_list */
        $array = $this->setArrayTraining($request);

        /** merubah array agar menjadi object seperti request */
        $array = \Helper::instance()->MakeRequest($array);

        /** menambahkan auth created by dan updated by */
        $array = $this->HelperService->addAuthInsert($array);

        DB::transaction(function () use ($array, $request) {
            $data = $this->RequestInterfaces->CreateRequest($array);

            if ($request->method_participant == 'upload') {
                $import = new UploadParticipant($this->RequestInterfaces,'import',$array->training_id);
                Excel::import($import, $request->file('file'), null, \Maatwebsite\Excel\Excel::XLSX);
                $this->updateTotalParticipanct($import->success,$data); // update jumlah total participant berdasarkan data yang berhasil di upload
            }else{
                $participant = $this->createParticipant($data, $request);
                $this->RequestInterfaces->createParticipant($participant);
            }

            try {
                event(new SetApprovalEvent($data));
            } catch (\Throwable $th) {
                throw new Exception("Can't Set Approval");
            }

            try {
                event(new SendMailEvent($data));
            } catch (\Throwable $th) {
                throw new Exception("Can't Send Email");
            }
        });
    }

    /**
     * createParticipant
     *
     * @param  $data berisi data yang sudah diinsert ke table mst_training_list
     * @param  $request berisi semua data request yang di kirim dari frontend
     * @return $array membuat array untuk insert batch kedalam table mst_training_list_participant
     * 
     */
    public function createParticipant($data, $request)
    {
        $array = [];
        for ($i = 0; $i < count($request->participant_name); $i++) {
            $arr = [
                "training_id" => $data->training_id,
                "training_user_nik" => $request->participant_name[$i],
                "created_by" => Auth::user()->user_name,
                "updated_by" => Auth::user()->user_name,
            ];
            array_push($array, $arr);
        }
        return $array;
    }

    public function setArrayTraining($request)
    {
        return [
            "training_id" => $this->setUpId(),
            "training_topic" => $request->training_topic,
            "vendor_id" => $request->vendor_id == "other" ? "" : $request->vendor_id,
            "method_id" => $request->method_id,
            "training_start_date" => $request->training_start_date,
            "training_end_date" => $request->training_end_date,
            "start_training_hour" => $request->start_training_hour,
            "end_training_hour" => $request->end_training_hour,
            "training_fee" => $this->removeRupiah($request->training_fee),
            "training_participants" => $this->countTrainingParticipant($request), // digunakan untuk set total training participant
            "period_id" => $this->HelperService->getIdPriodNow(),
            "training_date_request" => Carbon::now()->format('Y-m-d'),
            "training_purpose" => $request->training_purpose
        ];
    }

    public function countTrainingParticipant($request)
    {
        if ($request->method_participant == 'upload') {
            return 0;
        }else{
            return $request->training_participants;
        }
    }

    public function removeRupiah($fee)
    {
        return str_replace('.', '', str_replace('Rp. ', '', $fee));
    }

    public function customRequest($request)
    {
        $training_date = explode('sd', $request->training_date);
        if (count($training_date) == 2) {
            $training_hour = explode('-', $request->training_hour);
            $request->merge([
                "training_start_date" => trim($training_date[0]), // 0 untuk start
                "training_end_date" => trim($training_date[1]), // 1 untuk end
                "start_training_hour" => trim($training_hour[0]), // 0 untuk end
                "end_training_hour" => trim($training_hour[1]) // 1 untuk end
            ]);
            $request->request->remove('training_date');
            $request->request->remove('training_hour');
            $request->request->remove('table-upload_length');
            return $request;
        }

        throw new Exception("Date Of Training Wrong");
    }

    public function setUpId()
    {
        $id = $this->RequestInterfaces->getLastId();
        if ($id == null) {
            $newID = sprintf("%02s", 1) . "/" . date("my") . "TRG";
        } else {
            $explode = explode("/", $id->training_id);
            $newID = sprintf("%02s", $explode[0] + 1) . "/" . date("my") . "TRG";
        }
        return $newID;
    }

    /**
     * update
     *
     * @param  mixed $request
     * @return void
     */
    public function update($request)
    {
        $request->request->remove('vendor_type');
        $request = $this->HelperService->addAuthUpdate($request);

        if ($request->training_date_actual != null) {
            $training_date_actual = explode('sd', $request->training_date_actual);
            $request->merge([
                "training_start_date_actual" => trim($training_date_actual[0]), // 0 untuk start
                "training_end_date_actual" => trim($training_date_actual[1]), // 1 untuk end
            ]);

            $request->request->remove('training_date_actual');
        }

        $training_hour = explode('-', $request->training_hour);
        $request->merge([
            "training_fee" => $this->removeRupiah($request->training_fee),
            "start_training_hour" => trim($training_hour[0]), // 0 untuk end
            "end_training_hour" => trim($training_hour[1]) // 1 untuk end
        ]);
        $request->request->remove('training_hour');


        return DB::transaction(function () use ($request) {
            $dataBeforeUpdate = $this->RequestInterfaces->getDetailTraining($request->training_id); // mengambil data sebelum di update
            $this->RequestInterfaces->update($request); // proses update data 

            //proses update participant
            $this->UpdateParticipant($request);

            //kondisi menentukan apakah perlud dikirim email lagi atau tidak
            if ($dataBeforeUpdate->training_fee != $this->removeRupiah($request->training_fee)) {

                //mengeset approval nik menjadi null 
                try {
                    event(new SetNullApprovalEvent($dataBeforeUpdate->TrainingApproval->training_approval_id));
                } catch (\Throwable $th) {
                    throw new Exception("Can't Referesh Approval");
                }

                //mengeset ulang approval

                try {
                    event(new SetApprovalEvent($request));
                } catch (\Throwable $th) {
                    throw new Exception("Can't Set Approval");
                }

                //mengirim ulang kembali email
                try {
                    $data = $this->RequestInterfaces->getDetailTraining($request->training_id);
                    event(new SendMailEvent($data));
                } catch (\Throwable $th) {
                    throw new Exception("Can't Send Email");
                }
            }
        });
    }

    public function UpdateParticipant($request) // fungsi ini melakukan update participant berdasarkan requestnya
    {
        return DB::transaction(function () use ($request) {
            $this->RequestInterfaces->deleteTrainingParticipant($request->training_id);
            $participant = $this->createParticipant($request,$request);
            $this->RequestInterfaces->createParticipant($participant);
        });
    }

    public function uploadParticipant($request)
    {
        $import = new UploadParticipant($this->RequestInterfaces,'validate');
        Excel::import($import, $request->file('file'), null, \Maatwebsite\Excel\Excel::XLSX);
        $data = Excel::toArray([], $request->file('file'));
        $rows = (int)$import->rows - 1 ; // dikurang 1 karean headingnya ikut terhitung
        unset($data[0][0]); // dihapus dulu array pertama karena itu header
        // dd($data[0],$import->success,$import->rows - 1,$import->fail);
        return $data = [
            "message"=>"Total Data = {$rows} , 
                        Success Upload = {$import->success}, 
                        Fail Upload = {$import->fail}",
            "dataTable"=>$this->HelperService->DataTablesResponse(($data[0])),
            "detailFail"=>$import->errors
        ];
    }

    public function updateTotalParticipanct($total_participant,$data)
    {
        return DB::transaction(function () use($total_participant,$data) {
            $data = [
                "training_participants" => $total_participant,
                "training_id" => $data->training_id
            ];
            $request = \Helper::instance()->MakeRequest($data);
            $request = $this->HelperService->addAuthUpdate($request);
            $this->RequestInterfaces->update($request);
        });
        
    }
}
