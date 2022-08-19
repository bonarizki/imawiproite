<?php

namespace App\Services\Koperasi;

use App\Repository\Koperasi\Order\Interfaces\OrderInterfaces;
use App\Helper\HelperService;
use App\Repository\Koperasi\OrderLimit\Interfaces\OrderLimitInterfaces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repository\Koperasi\Product\Interfaces\ProductInterfaces;
use Exception;
use App\Events\Koperasi\MailOrderEvent;
use App\Events\Koperasi\CreateOrderJurnalEvent;
use App\Events\Koperasi\DeleteOrderJurnalEvent;

class OrderService
{
    private $OrderInterfaces,
        $HelperService,
        $ProductInterfaces,
        $OrderLimitInterfaces;

    public function __construct(
        OrderInterfaces $OrderInterfaces,
        HelperService $HelperService,
        ProductInterfaces $ProductInterfaces,
        OrderLimitInterfaces $OrderLimitInterfaces
    ) {
        $this->OrderInterfaces = $OrderInterfaces;
        $this->HelperService = $HelperService;
        $this->ProductInterfaces = $ProductInterfaces;
        $this->OrderLimitInterfaces = $OrderLimitInterfaces;
    }

    public function CreateOrder()
    {
        DB::transaction(function () {
            $limited = $this->validateOrderLimit(); // mengambil array yang berisi category id yang melebih limit

            if (count($limited) > 0) throw new Exception("array=" . json_encode($limited));

            $orderHeader = $this->createHeader();

            try { // proses update detail order agar memiliki order header id
                $this->updateDetail($orderHeader->order_header_id);
            } catch (\Throwable $th) {
                throw new Exception("message Can't place order");
            }

            //  NON AKTIFKAN TERLEBIH DAHULU 
            // try { // prosess mengirim order ke jurnal by API
            //     event(new CreateOrderJurnalEvent($orderHeader->order_header_id,'POST'));
            // } catch (\GuzzleHttp\Exception\ClientException $e) {
            //     $response = $e->getResponse();
            //     $responseBodyAsString = json_decode($response->getBody()->getContents());
            //     throw new Exception(implode(',',$responseBodyAsString->error_full_messages));
            // }

            try { // mengirim email order ke user
                event(new MailOrderEvent($orderHeader->order_header_id));
            } catch (\Throwable $th) {
                throw new Exception("message Can't Send Email");
            }
        });
    }

    public function createHeader()
    {
        $request = [
            "order_header_id" => $this->setUpId(),
            "period_id" => $this->HelperService->getIdPriodNow(),
            "user_nik" => Auth::user()->user_nik
        ];

        $request = \Helper::instance()->MakeRequest($request); // merubah array menjadi request
        $request = $this->HelperService->addAuthInsert($request); // menambahkan created ad dan created by
        return $this->OrderInterfaces->create($request);
    }

    public function updateDetail($order_header_id)
    {
        $cartUser = $this->ProductInterfaces->detailCartUser(Auth::user()->user_nik); // item yang aka  user beli
        foreach ($cartUser as $item) {
            $request = [
                "order_header_id" => $order_header_id,
                "order_detail_id" => $item->order_detail_id
            ];
            $request = \Helper::instance()->MakeRequest($request); // merubah array menjadi request
            $request = $this->HelperService->addAuthUpdate($request); // menambahkan created ad dan created by
            $this->OrderInterfaces->updateDetail($request);
        }
    }

    public function validateOrderLimit()
    {
        $totalOrderUser = $this->OrderInterfaces->totalOrderUser(Auth::user()->user_nik);
        $orderLimit = $this->OrderLimitInterfaces->index();
        $limited = []; // variabel yang akan menampung category id dari order yang melebih limit
        foreach ($totalOrderUser as $item) { //looping total order user
            foreach ($orderLimit as $limit) { // looping order limit
                if ($item->category_id == $limit->category_id) { // jika order category limit dan category order user sama
                    if ($item->total_qty_order > $limit->order_limit) { // jika total category order user lebih besar dari order limit category
                        $limited = array_merge([$item->category_id], $limited);
                    }
                }
            }
        }
        return $limited; //mengembalikan array yang berisi id category yang melebih limit
    }

    public function setUpId()
    {
        $date_today = date('Ymd');
        $id = $this->OrderInterfaces->getLastId();
        if ($id != null) {
            $date_id = explode('-', $id->order_header_id); //[0] array 0 itu pasti PO-347284718 e.g
            if ($date_today > $date_id[1]) { //[1] array 1 itu bentuknya 20210803 e.g
                return "PO-" . date('Ymd') . "-" . sprintf("%03s", 1);
            } else {
                return "PO-" . date('Ymd') . "-" . sprintf("%03s", $date_id[2] + 1);
            }
        }else{
            return "PO-" . date('Ymd') . "-" . sprintf("%03s", 1);
        }
    }

    public function allOrder($request)
    {
        $data = $this->OrderInterfaces->allOrder($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function edit($id)
    {
        return $this->OrderInterfaces->HeaderDetail(str_replace('.', '/', $id));
    }

    public function deleteOrder($request)
    {
        return DB::transaction(function () use ($request) {
            $this->updateOrderHeader($request, 'reject');
            $this->deleteHeader($request);
            $this->deleteDeteail($request->order_header_id);

            //DELETE DATA YANG ADA DI JURNAL ID
            // try {
            //     event(new DeleteOrderJurnalEvent($request->order_header_id));
            // } catch (\GuzzleHttp\Exception\ClientException $e) {
            //     $response = $e->getResponse();
            //     $responseBodyAsString = json_decode($response->getBody()->getContents());
            //     if ($responseBodyAsString != null) {
            //         throw new Exception(implode(',',$responseBodyAsString->error_full_messages));
            //     }
            // }
        });
    }

    public function deleteHeader($request)
    {
        DB::transaction(function () use ($request) {
            $this->OrderInterfaces->deleteHeader($request);
        });
    }

    public function deleteDeteail($order_header_id)
    {
        DB::transaction(function () use ($order_header_id) {
            $detailOrder = $this->OrderInterfaces->detailOrderUser($order_header_id);
            if (count($detailOrder) > 0) {
                foreach ($detailOrder as $item) {
                    $request = \Helper::instance()->MakeRequest(['order_detail_id' => $item->order_detail_id]);
                    $this->OrderInterfaces->deleteDeteail($request);
                }
            }
        });
    }

    public function updateOrderHeader($request, $type = 'done')
    {
        $request->merge([
            "order_status" => $type,
        ]);
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->OrderInterfaces->updateHeader($request);
    }

    public function reverseOrder($request)
    {
        DB::transaction(function () use ($request) {

            $this->updateOrderHeader($request, 'process');
            $request = $this->HelperService->addAuthUpdate($request);
            $this->reverseHeader($request);
            $this->reverseDetail($request->order_header_id);
        });
    }

    public function reverseHeader($request)
    {
        DB::transaction(function () use ($request) {
            $request->merge([ // agar ada log
                "deleted_by" => NULL,
                "deleted_at" => NULL
            ]);
            $this->OrderInterfaces->updateHeader($request);
        });
    }

    public function reverseDetail($order_header_id)
    {
        DB::transaction(function () use ($order_header_id) {
            $detailOrder = $this->OrderInterfaces->detailOrderUser($order_header_id);
            foreach ($detailOrder as $item) {
                $request = \Helper::instance()->MakeRequest(['order_detail_id' => $item->order_detail_id]);
                $request->merge([ // agar ada log
                    "deleted_by" => NULL,
                    "deleted_at" => NULL
                ]);
                $request = $this->HelperService->addAuthUpdate($request);
                $this->OrderInterfaces->updateDetail($request);
            }
        });
    }

    public function HandleUpdateOrder($request)
    {
        return DB::transaction(function () use ($request) {
            foreach ($request->data as $item) {
                $detail_item = $this->ProductInterfaces->getDetailItemCart($item['order_detail_id']);
                $detail = $this->ProductInterfaces->getDetailProduct($detail_item->product_id);
                $newrequest = \Helper::instance()->MakeRequest($item);
                $newrequest = $this->HelperService->addAuthUpdate($newrequest);
                $newrequest->merge([
                    "total" => $newrequest->qty * $detail->product_price_koperasi
                ]);
                $this->ProductInterfaces->updateQty($newrequest);
            }

            // try { // prosess mengirim order ke jurnal by API
            // event(new CreateOrderJurnalEvent($request->id,'PATCH'));
            // } catch (\GuzzleHttp\Exception\ClientException $e) {
            //     $response = $e->getResponse();
            //     $responseBodyAsString = json_decode($response->getBody()->getContents());
            //     throw new Exception(implode(',',$responseBodyAsString->error_full_messages));
            // }
        });
    }
}
