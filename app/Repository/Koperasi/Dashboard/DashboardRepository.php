<?php

namespace App\Repository\Koperasi\Dashboard;

use App\Model\Koperasi\OrderDetail;
use App\Model\Koperasi\OrderHeader;
use App\Repository\Koperasi\Dashboard\Interfaces\DashboardInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Koperasi\Product;

class DashboardRepository implements DashboardInterfaces
{
    public static function GetMenuByUrl($request)
    {
        return DB::table('mst_koperasi_menu_parent')
            ->select(
                'mst_koperasi_menu_parent.menu_parent_id',
                'mst_koperasi_menu_parent.menu_parent_icon',
                'mst_koperasi_menu_parent.menu_parent_name',
                'mst_koperasi_menu_parent.menu_parent_url',
                'mst_koperasi_menu_child.menu_child_id',
                'mst_koperasi_menu_child.menu_child_name',
                'mst_koperasi_menu_child.menu_child_icon',
                'mst_koperasi_menu_child.menu_child_url',
                'mst_koperasi_menu_grand_child.menu_grand_child_id',
                'mst_koperasi_menu_grand_child.menu_grand_child_icon',
                'mst_koperasi_menu_grand_child.menu_grand_child_name',
                'mst_koperasi_menu_grand_child.menu_grand_child_url'
            )
            ->leftJoin('mst_koperasi_menu_child', function ($join) {
                $join->on('mst_koperasi_menu_child.menu_parent_id', '=', 'mst_koperasi_menu_parent.menu_parent_id')
                    ->whereNull('mst_koperasi_menu_parent.deleted_at')
                    ->whereNull('mst_koperasi_menu_child.deleted_at');
            })
            ->leftJoin('mst_koperasi_menu_grand_child', function ($join) {
                $join->on('mst_koperasi_menu_grand_child.menu_child_id', '=', 'mst_koperasi_menu_child.menu_child_id')
                    ->whereNUll('mst_koperasi_menu_grand_child.deleted_at');
            })
            ->where('mst_koperasi_menu_parent.menu_parent_url', '=', $request->path)
            ->orWhere('mst_koperasi_menu_child.menu_child_url', '=', $request->path)
            ->orWhere('mst_koperasi_menu_grand_child.menu_grand_child_url', '=', $request->path)
            ->first();
    }

    public static function getTotalMember()
    {
        $query = "  SELECT 
                        'Member' as name, 
                        count(*) as total 
                    FROM mst_koperasi_member
                        WHERE member_status = 'member'
                    UNION
                    SELECT 
                        'Non-Member' as name, 
                        count(*) as total 
                    FROM mst_koperasi_member
                        WHERE member_status = 'non-member'";
        return DB::select($query);
    }

    public static function getTotalOrderMember($request)
    {
        $queryCondition = " AND MONTH(mkoh.created_at) = '$request->month_name'
                            AND YEAR(mkoh.created_at) = '$request->year_name'";

        $query = "  SELECT 
                        'Member' as name,
                        count(*) as total
                    FROM mst_koperasi_member as mkm
                        JOIN mst_koperasi_order_header as mkoh
                            ON mkoh.user_nik = mkm.user_nik
                            AND mkoh.order_status in ('process','done')
                    WHERE mkm.member_status = 'member'
                    $queryCondition
                    UNION
                    SELECT 
                        'Non-Member' as name,
                        count(*) as value
                    FROM mst_koperasi_member as mkm
                        JOIN mst_koperasi_order_header as mkoh
                            ON mkoh.user_nik = mkm.user_nik
                            AND mkoh.order_status in ('process','done')
                    WHERE mkm.member_status = 'non-member'
                    $queryCondition";

        return DB::select($query);
    }

    public static function getTotalOrderStatus($request)
    {
        $queryCondition = " AND MONTH(created_at) = '$request->month_name'
                            AND YEAR(created_at) = '$request->year_name'";

        $query = "  SELECT 
                        'Process' as name,
                        IFNULL(COUNT(*), 0) AS total
                    FROM `mst_koperasi_order_header` AS mkoh
                    WHERE order_status = 'process'
                        AND deleted_at IS NULL
                        $queryCondition
                    UNION
                    SELECT 
                        'Done' as name,
                        IFNULL(COUNT(*), 0) AS total
                    FROM `mst_koperasi_order_header` AS mkoh
                    WHERE order_status = 'done'
                        AND deleted_at IS NULL
                        $queryCondition
                    UNION
                    SELECT 
                        'Cancel' as name,
                        IFNULL(COUNT(*), 0) AS total
                    FROM `mst_koperasi_order_header` AS mkoh
                    WHERE order_status = 'cancel'
                        AND deleted_at IS NULL
                        $queryCondition
                    UNION
                    SELECT 
                        'Reject' as name,
                        IFNULL(COUNT(*), 0) AS total
                    FROM `mst_koperasi_order_header` AS mkoh
                    WHERE order_status = 'reject'
                    $queryCondition
                    ";

        return DB::select($query);
    }


    public static function most_order($request)
    {
        return OrderDetail::select('product_id')
            ->selectRaw('sum(qty) as total')
            ->with(['Product' => function ($query) {
                return $query->union(Product::getProductSkincare());
            }])
            ->whereYear('created_at', '=', $request->year_name)
            ->whereMonth('created_at', '=', $request->month_name)
            ->groupBy('product_id')
            ->orderBy('total', 'desc')
            ->limit('5')
            ->get();
    }

    public static function brand_rank($request)
    {
        return OrderDetail::select('brand_rank', 'product_id')
            ->selectRaw('sum(qty) as total')
            ->with(['Product' => function ($query) {
                return $query->union(Product::getProductSkincare());
            }])
            ->whereYear('created_at', '=', $request->year_name)
            ->whereMonth('created_at', '=', $request->month_name)
            ->groupBy('brand_rank')
            ->orderBy('total', 'desc')
            ->limit('5')
            ->get();
    }

    public static function top_spender_m_2($request)
    {
        $month_1 = "0";
        $month_2 = "0";
        if ($request->month_name >= "03") {
            $month_2 .= (string)$request->month_name - 2;
            $month_1 .= (string)$request->month_name - 1;
            $year_name_1 = $request->year_name;
            $year_name_2 = $request->year_name;
        } else {
            if ($request->month_name == "01") {
                $month_2 = "12";
                $month_1 = "11";
                $year_name_1 = $request->year_name - 1;
                $year_name_2 = $request->year_name - 1;
            } else {
                $month_2 = "12";
                $month_1 = "01";
                $year_name_1 = $request->year_name - 1;
                $year_name_2 = $request->year_name;
            }
        }

        $queryCondition = " AND DATE_FORMAT(mkoh.created_at, '%Y-%m')
                            BETWEEN '$year_name_1-$month_2' AND '$year_name_2-$month_1'";
        $query = "  SELECT
                        mkoh.user_nik,
                        sum(mkod.total) as total,
                        mmu.user_name,
                        mmd.department_name
                    FROM mst_koperasi_order_header AS mkoh
                        JOIN mst_koperasi_order_detail AS mkod
                            ON mkoh.order_header_id = mkod.order_header_id
                        JOIN mst_main_user mmu 
                            ON mmu.user_nik = mkoh.user_nik
                        JOIN mst_main_department mmd 
                        	ON mmd.department_id = mmu.department_id
                    WHERE mkoh.order_status = 'done'
                        $queryCondition
                        AND mkoh.deleted_at IS NULL 
                        AND mkod.deleted_at IS NULL 
                    GROUP BY mkoh.user_nik 
                    LIMIT 1";
        return DB::select($query);
    }

    public static function top_spender_m_1($request)
    {
        $month = "0";
        if ($request->month_name >= "02") {
            $month .=  $request->month_name - 1;
            $year =  $request->year_name;
        } else {
            $month =  "12";
            $year =  $request->year_name - 1;
        }
        $queryCondition = " AND MONTH(mkoh.created_at) = '$month'
                            AND YEAR(mkoh.created_at) = '$year'";
        $query = "  SELECT
                        mkoh.user_nik,
                        sum(mkod.total) as total,
                        mmu.user_name,
                        mmd.department_name
                    FROM mst_koperasi_order_header AS mkoh
                        JOIN mst_koperasi_order_detail AS mkod
                            ON mkoh.order_header_id = mkod.order_header_id
                        JOIN mst_main_user mmu 
                            ON mmu.user_nik = mkoh.user_nik
                        JOIN mst_main_department mmd 
                            ON mmd.department_id = mmu.department_id
                    WHERE mkoh.order_status = 'done'
                        $queryCondition
                        AND mkoh.deleted_at IS NULL 
                        AND mkod.deleted_at IS NULL 
                    GROUP BY mkoh.user_nik 
                    LIMIT 1";
        return DB::select($query);
    }

    public static function top_spender_t_m($request) //thismonth
    {
        $queryCondition = " AND MONTH(mkoh.created_at) = '$request->month_name'
                            AND YEAR(mkoh.created_at) = '$request->year_name'";
        $query = "  SELECT
                        mkoh.user_nik,
                        sum(mkod.total) as total,
                        mmu.user_name,
                        mmd.department_name
                    FROM mst_koperasi_order_header AS mkoh
                        JOIN mst_koperasi_order_detail AS mkod
                            ON mkoh.order_header_id = mkod.order_header_id
                        JOIN mst_main_user mmu 
                            ON mmu.user_nik = mkoh.user_nik
                        JOIN mst_main_department mmd 
                            ON mmd.department_id = mmu.department_id
                    WHERE mkoh.order_status = 'done'
                        $queryCondition
                        AND mkoh.deleted_at IS NULL 
                        AND mkod.deleted_at IS NULL 
                    GROUP BY mkoh.user_nik 
                    LIMIT 1";

        return DB::select($query);
    }
}
