<?php

namespace App\Repository\Koperasi\Order;

use App\Model\Koperasi\OrderDetail;
use App\Model\Koperasi\OrderDetailMaster;
use App\Model\Koperasi\OrderHeader;
use App\Repository\Koperasi\Order\Interfaces\OrderInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Koperasi\Product;

class OrderRepository implements OrderInterfaces
{
    public static function totalOrderUser($user_nik)
    {
        $query = "  SELECT 
                        category_id,
                        sum(qty) as total_qty_order
                    FROM mst_koperasi_order_detail
                        WHERE user_nik = '" . $user_nik . "'
                        AND YEAR(created_at) = " . date('Y') . " 
                        AND MONTH(created_at) = " . date('m') . " 
                        AND deleted_at is null
                    GROUP BY category_id";

        return DB::select($query);
    }

    public static function getLastId()
    {
        return OrderHeader::select('order_header_id')
            ->latest()
            ->withTrashed()
            ->first();
    }

    public static function create($request)
    {
        $data = null;
        return DB::transaction(function () use ($request, &$data) {
            $data = OrderHeader::create($request->except("_token"));
            $request->merge([
                "order_header_id" => $data->order_header_id
            ]);
            \Helper::instance()->log("CREATE", $request, "App\Model\Koperasi\OrderHeader");
            return $data;
        });
        return $data;
    }

    public static function updateDetail($request)
    {
        return DB::transaction(function () use ($request) {
            \Helper::instance()->log("UPDATE", $request, "App\Model\Koperasi\OrderDetailMaster");
            OrderDetailMaster::withTrashed()->find($request->order_detail_id)
                ->update($request->except("_token"));

            \Helper::instance()->log("UPDATE", $request, "App\Model\Koperasi\OrderDetail");
            OrderDetail::withTrashed()->find($request->order_detail_id)
                ->update($request->except("_token"));
        });
    }

    public static function detailOrderUser($order_header_id)
    {
        return OrderDetail::withTrashed()
            ->with(['Product' => function ($query) {
                return $query->select(Product::selectField())
                ->union(Product::getProductSkincare());
            }])
            ->where('order_header_id', $order_header_id)
            ->orderBy('brand_rank')
            ->orderBy('range_rank')
            ->get();
    }

    public static function allOrder($request)
    {
        $query = OrderHeader::with([
            'Period',
            'Detail',
            'Detail.Product',
            'User'
        ]);

        if ($request->order_status != null) {
            $query->where('order_status', $request->order_status);
        } else if ($request->type == "proceed") {
            $query->whereIN('order_status', ['process', 'done']);
        } else if ($request->type == "unproceed") {
            $query->whereIN('order_status', ['reject', 'cancel']);
        }

        if ($request->department_id != null) $query->whereHas('User.Department', function ($q) use ($request) {
            $q->where('department_id', 'like', '%' . $request->department_id . '%');
        });

        if ($request->user_nik != null) $query->whereHas('User', function ($q) use ($request) {
            $q->where('user_nik', 'like', '%' . $request->user_nik . '%');
        });

        if ($request->user_name != null) $query->whereHas('User', function ($q) use ($request) {
            $q->where('user_name', 'like', '%' . $request->user_name . '%');
        });

        if ($request->period_id != null) $query->where('period_id', $request->period_id);

        return $query->orderBy('created_at', 'desc')
            ->withTrashed()
            ->get()
            ->makeVisible(['created_by', 'created_at']);
    }

    public static function deleteHeader($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('DELETE', $request, "App\Model\Koperasi\OrderHeader");
            OrderHeader::find($request->order_header_id)
                ->delete();
        });
    }

    public static function deleteDeteail($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('DELETE', $request, "App\Model\Koperasi\OrderDetail");
            OrderDetail::find($request->order_detail_id)
                ->delete();
        });
    }

    public static function HeaderDetail($id)
    {
        return OrderHeader::with([
            'User',
            'Detail' => function ($q) {
                $q->orderBy('brand_rank')->orderBy('range_rank');
            },
            'Detail.Product' => function ($query) {
                return $query->select(Product::selectField())
                    ->union(Product::getProductSkincare());
            },
            'User.Member'
        ])
            ->where('order_header_id', $id)
            ->first();
    }

    public static function updateHeader($request)
    {
        return DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, "App\Model\Koperasi\OrderHeader");
            OrderHeader::withTrashed()->find($request->order_header_id)
                ->update($request->except('_token'));
        });
    }

    public static function getJurnalID($order_header_id)
    {
        return OrderHeader::withTrashed()
            ->select('jurnal_id')
            ->where('order_header_id', $order_header_id)
            ->first();
    }
}
