<?php

namespace App\Listeners\Koperasi;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Koperasi\MailOrderEvent;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use Illuminate\Support\Facades\Auth;
use App\Mail\Koperasi\InvoiceOrder;
use App\Repository\Koperasi\Order\Interfaces\OrderInterfaces;
use Exception;

class MailOrderListener
{
    private $UserInterfaces,$OrderInterfaces;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserInterfaces $UserInterfaces,OrderInterfaces $OrderInterfaces)
    {
        $this->UserInterfaces = $UserInterfaces;
        $this->OrderInterfaces = $OrderInterfaces;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MailOrderEvent $event)
    {
        $user = $this->UserInterfaces->getUserByNik(Auth::user()->user_nik);
        $detailOrder = $this->OrderInterfaces->detailOrderUser($event->order_header_id); // item yang akan  user beli
        try {
            \Mail::to(['address' => $user->user_email])
                ->cc([
                    'system.imawiproite@wipro-unza.co.id',
                    // 'viola.putri@wipro-unza.co.id'
                    // 'nurul.amaliyah@wipro-unza.co.id',
                    // 'ardhini.retno@wipro-unza.co.id',
                    // 'bona.rizki@wipro-unza.co.id'
                ])
                ->send(new InvoiceOrder($user,$detailOrder,$event->order_header_id));
        } catch (\Throwable $th) {
            throw new Exception("Can't Send Email");
        }
    }
}
