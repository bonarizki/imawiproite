<?php

namespace App\Listeners\Dashboard;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\MailDashboard\NewUser;
use Exception;
use App\Events\Dashboard\NewUserEvent;

class NewUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewUserEvent $event)
    {
        try {
            \Mail::to(['address' => $event->data->user_email])
                ->cc([
                    'system.imawiproite@wipro-unza.co.id',
                ])
                ->send(new NewUser($event->data));
        } catch (\Throwable $th) {
            throw new Exception("Can't Send Email");
        }
    }
}
