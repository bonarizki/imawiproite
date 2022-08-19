<?php

namespace App\Listeners\Training;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Training\SetNullApprovalEvent;
use Illuminate\Support\Facades\Auth;
use App\Repository\Training\Approval\Interfaces\ApprovalInterfaces;

class SetNullApprovalListener
{
    public $ApprovalInterfaces;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ApprovalInterfaces $ApprovalInterfaces)
    {
        $this->ApprovalInterfaces = $ApprovalInterfaces;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event adalah data / id yang sudah di set ketika event dimulai
     * @return void
     */
    public function handle(SetNullApprovalEvent $event)
    {
        $array = $this->setArrayNull(); // pembuatan array yang berisi nama field yang ingin di set null
        $array = array_merge($array, $this->setArrayNull('_date'));
        $array = array_merge($array, [
            "updated_by" => Auth::user()->user_name,
            "training_approval_id" => $event->id
        ]);
        $request = \Helper::instance()->MakeRequest($array);
        $this->ApprovalInterfaces->UpdateApproval($request);
    }

    /**
     * setArrayDateNull
     *
     * @return void function untuk membuat array yang berisi nama field ( training_approval_nik & training_approval_nik_date)
     * yang akan di set null
     */
    public function setArrayNull($date = NULL)
    {
        $array = [];
        for ($i = 1; $i <= 8; $i++) {
            $type = $i;
            if ($i == 7)
                $type = "ceo";
            if ($i == 8)
                $type = "hr";
            $index = "training_approval_nik_" . $type . $date;
            $array = array_merge($array, [$index => NULL]);
        }
        return $array;
    }
}
