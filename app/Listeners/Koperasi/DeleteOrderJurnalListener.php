<?php

namespace App\Listeners\Koperasi;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Koperasi\DeleteOrderJurnalEvent as DeleteOrder;
use App\Repository\Koperasi\Order\Interfaces\OrderInterfaces;
use GuzzleHttp\Client;

class DeleteOrderJurnalListener
{
    public $OrderInterfaces;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(OrderInterfaces $OrderInterfaces)
    {
        $this->OrderInterfaces = $OrderInterfaces;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(DeleteOrder $event)
    {
        $data = $this->OrderInterfaces->getJurnalID($event->order_id);
        $client = new Client();
        $response = $client->request('DELETE', 'https://api.jurnal.id/core/api/v1/sales_orders/' . $data->jurnal_id, [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'debug'        => true,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'apikey' => env('JURNAL_KEY'),
            ],
        ]);
    }
}
