<?php

namespace App\Repository\Ticketing\Dashboard;

use App\Repository\Ticketing\Dashboard\Interfaces\DashboardInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Ticketing\RequestTicketingHeader;
use Illuminate\Support\Facades\Auth;

class DashboardRepository implements DashboardInterfaces
{
    public static function GetMenuByUrl($request)
    {
        return DB::table('mst_ticketing_menu_parent')
            ->leftJoin('mst_ticketing_menu_child', 'mst_ticketing_menu_child.menu_parent_id', '=', 'mst_ticketing_menu_parent.menu_parent_id')
            ->leftJoin('mst_ticketing_menu_grand_child', 'mst_ticketing_menu_grand_child.menu_child_id', '=', 'mst_ticketing_menu_child.menu_child_id')
            ->where('mst_ticketing_menu_parent.menu_parent_url', '=', $request->path)
            ->orWhere('mst_ticketing_menu_child.menu_child_url', '=', $request->path)
            ->orWhere('mst_ticketing_menu_grand_child.menu_grand_child_url', '=', $request->path)
            ->select(
                'mst_ticketing_menu_parent.menu_parent_id',
                'mst_ticketing_menu_parent.menu_parent_icon',
                'mst_ticketing_menu_parent.menu_parent_name',
                'mst_ticketing_menu_parent.menu_parent_url',
                'mst_ticketing_menu_child.menu_child_id',
                'mst_ticketing_menu_child.menu_child_name',
                'mst_ticketing_menu_child.menu_child_icon',
                'mst_ticketing_menu_child.menu_child_url',
                'mst_ticketing_menu_grand_child.menu_grand_child_id',
                'mst_ticketing_menu_grand_child.menu_grand_child_icon',
                'mst_ticketing_menu_grand_child.menu_grand_child_name',
                'mst_ticketing_menu_grand_child.menu_grand_child_url'
            )
            ->first();
    }

    public static function getData($status,$request)
    {
        $query =  RequestTicketingHeader::with(['RequestBy','Type','Approval']);

        if ($request->type != 'user') {
            if ($request->department_id != null) {
                $query->whereHas('RequestBy', function ($q) use($request) {
                    $q->where('department_id', $request->department_id);
                });
            }
        }else{
            $query->whereHas('RequestBy', function ($q) {
                $q->where('department_id', Auth::user()->department_id);
            });
        }

        return $query->where('period_id', $request->period_id)
            ->where('ticket_status', $status)
            ->get()
            ->makeVisible('created_at');
    }

    public static function getAllDepartmentTicket($period_id)
    {
        $query =  "select 
                        mmd.department_name as name,
                        count(ticket_id) as total
                    from mst_main_department mmd
                        join mst_main_user mmu
                            on mmu.department_id = mmd.department_id 
                            and mmu.deleted_at is null
                        left join trans_ticketing_header tth 
                            on tth.user_ticketing_request = mmu.user_nik
                            and tth.period_id = '$period_id'
                    group by mmu.department_id";
        return DB::select($query);
    }
}
