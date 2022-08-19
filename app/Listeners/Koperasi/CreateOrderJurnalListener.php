<?php

namespace App\Listeners\Koperasi;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Koperasi\CreateOrderJurnalEvent as Order;
use App\Repository\Koperasi\Order\Interfaces\OrderInterfaces;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Helper\HelperService;




class CreateOrderJurnalListener
{
    private $OrderInterfaces, $HelperService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(OrderInterfaces $OrderInterfaces, HelperService $HelperService)
    {
        $this->OrderInterfaces = $OrderInterfaces;
        $this->HelperService = $HelperService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Order $event)
    {
        $data = $this->OrderInterfaces->HeaderDetail($event->order_id);
        $request = $this->CreateRequestJurnal($data, $event);
        $url = $this->selectURL($event); // mendapatkan url api berdasarkan methodnya;
        $client = new Client();
        $response = $client->request($event->method, $url, [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'debug'        => true,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'apikey' => env('JURNAL_KEY'),
            ],
            \GuzzleHttp\RequestOptions::JSON => $request
        ]);

        $json = json_decode((string) $response->getBody()); // get response and change to json
        if ($response->getStatusCode() == 201) { // jika status code 201 / created maka input jurnal_id ke header order
            $this->updateHeader($event, $json);
        }
        return $response;
    }

    /**
     * selectURL memilih url berdasarkan method
     *
     * @param  mixed $event paramater yang di berikan ketika memangil event, ada dua paramater yaitu order id dan method
     * @return void mengembalikan url dalam yang akan di gunakan
     */
    public function selectURL($event)
    {
        if ($event->method == 'POST') {
            return 'https://api.jurnal.id/core/api/v1/sales_orders';
        } elseif ($event->method == 'PATCH') {
            return 'https://api.jurnal.id/core/api/v1/sales_orders/' . $event->order_id;
        }
    }

    /**
     * CreateRequestJurnal membuat request jurnal
     *
     * @param  mixed $data berisikan data detail header dari sebuah order id
     * @param  mixed $event paramater yang di berikan ketika memangil event, ada dua paramater yaitu order id dan method
     * @return void mengembalikan data request dalam bentuk array
     */
    public function CreateRequestJurnal($data, $event)
    {
        return $data = [
            'sales_order' => [
                'transaction_date' => $this->createdDate($data->created_at),
                'transaction_lines_attributes' => $this->CreateTransactionArray($data->Detail),
                'reference_no' => $data->User->Member->member_code,
                'term_name' => '',
                'due_date' => $this->dueDate($data->created_at),
                'deposit_to_name' => '',
                'deposit' => 0,
                'discount_unit' => 0,
                'discount_type_name' => 'Percent',
                'person_name' => $data->User->Member->member_code . "-" . $data->User->user_name,
                'email' => $data->User->user_email,
                'transaction_no' => $event->order_id,
                'custom_id' => '',
                'tax_after_discount' => true,
            ],
        ];
    }

    /**
     * CreateTransactionArray membuat array detail item 
     *
     * @param  mixed $detail data detail item
     * @return void mengembalikan data detail item dalam bentuk array
     */
    public function CreateTransactionArray($detail)
    {
        $data = [];
        foreach ($detail as $item) {
            $discount = $item->diskon_1 + $item->diskon_2 + $item->diskon_3;
            $data[] = [
                'quantity' => $item->qty,
                'rate' => $item->Product->product_price_koperasi,
                'discount' => $discount,
                'product_name' => $item->Product->product_name,
            ];
        }
        return $data;
    }

    public function dueDate($date)
    {
        $date = strtotime($this->createdDate($date));
        return date("Y-m-d", strtotime("+1 month", $date));
    }

    public function createdDate($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }

    public function updateHeader($event, $data)
    {
        $request = \Helper::instance()->MakeRequest([
            "order_header_id" => $event->order_id,
            "jurnal_id" => $data->sales_order->id
        ]);
        $request = $this->HelperService->addAuthUpdate($request);
        $this->OrderInterfaces->updateHeader($request);
    }
}
