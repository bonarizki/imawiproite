<?php 

namespace App\Services\Training;

use App\Repository\Training\Approval\Interfaces\ApprovalInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Events\Training\SendMailEvent;
use Exception;

class ApprovalService 
{
    private $ApprovalInterfaces;
    private $HelperService;

    public function __construct(ApprovalInterfaces $ApprovalInterfaces, HelperService $HelperService)
    {
        $this->ApprovalInterfaces = $ApprovalInterfaces;
        $this->HelperService = $HelperService;
    }
    
    /**
     * getDataApproval 
     * mendapatkan data yang akan di approve
     * menggunakan user nik
     * @return void
     */
    public function getDataApproval()
    {
        $user_nik = Auth::user()->user_nik;
        $data = $this->ApprovalInterfaces->getDataApproval($user_nik);
        return $this->HelperService->DataTablesResponse($data);
    }
    
    /**
     * approveTraining 
     * proses approve
     *
     * @param  mixed $request adalah data request yang di kirim dari controller (view)
     * @return void
     */
    public function approveTraining($request)
    {
        return DB::transaction(function () use ($request) {
            $training = $this->ApprovalInterfaces->getTrainingApproval($request->training_id); //mendapatkan data training approval menggunakan id training
            $fieldUpdate = $this->searchField($training); // mendapatkan nama field yang akan di upadate
            $request = $this->fieldUpdate($fieldUpdate,$request);
            $request->merge([
                'training_approval_id' => $training->training_approval_id
            ]);

            //jika hr approve dan training fee < 5000000 maka update training status jadi approve atau ceo approve maka update training status jadi approve
            if ((in_array("training_approval_nik_hr",$fieldUpdate) && $training->Training->training_fee < 5000000) || in_array("training_approval_nik_ceo",$fieldUpdate))
                $request->merge([
                    "training_status" => "approve"
                ]);

            $data = $this->ApprovalInterfaces->approveTraining($request); //insert approve ke db
            
            //jika bukan hr yang approve maka kirim email atau training fee lebih besar maka kirim email 
            if ((!in_array("training_approval_nik_hr",$fieldUpdate) && $training->Training->training_fee < 5000000) || (in_array("training_approval_nik_hr",$fieldUpdate) &&  $training->Training->training_fee >= 5000000)) {
                //proses mengirim email
                try {
                    event(new SendMailEvent($data));
                } catch (\Throwable $th) {
                    throw new Exception("Can't Approve");
                }
            }
        });
    }
    
    /**
     * searchField
     * di gunakan untuk mendapatk field mana yang akan di update
     *
     * @param  mixed $training adalah data training approval
     * @return void
     */
    public function searchField($training)
    {
        $fieldName = [];
        
        for ($i=1; $i <=8 ; $i++) { 
            $training_approval = "training_approval_nik_";

            if ($i == 7 ) {
                $training_approval .= 'ceo';
            }elseif ($i == 8 ) {
                $training_approval .= 'hr';
            }else{
                $training_approval .= $i;
            }
            
            if ($training->$training_approval == Auth::user()->user_nik) {
                $fieldName = array_merge([$training_approval],$fieldName);
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
    public function fieldUpdate($fieldUpdate,$request)
    {
        foreach ($fieldUpdate as $item) {
            $request->merge([
                $item.'_date' => Carbon::now(),
            ]);
        }

        return $request;
    }

    public function rejectTraining($request)
    {
        return DB::transaction(function () use ($request) {
            $training = $this->ApprovalInterfaces->getTrainingApproval($request->training_id); //mendapatkan data training approval menggunakan id training
            $fieldUpdate = $this->searchField($training);
            $request = $this->fieldUpdate($fieldUpdate,$request);
            $request->merge([
                'training_approval_id' => $training->training_approval_id,
                'training_status' => 'reject'
            ]);
            $this->ApprovalInterfaces->rejectTraining($request);
        });
    }
}