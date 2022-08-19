<?php

namespace App\Repository\Resignation\Dashboard;

use App\Repository\Resignation\Dashboard\Interfaces\DashboardInterfaces;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardInterfaces
{
    public function GetMenuByUrl($request)
    {
        return DB::table('mst_resignation_menu_parent')
                    ->leftJoin('mst_resignation_menu_child', 'mst_resignation_menu_child.menu_parent_id', '=', 'mst_resignation_menu_parent.menu_parent_id')
                    ->leftJoin('mst_resignation_menu_grand_child', 'mst_resignation_menu_grand_child.menu_child_id', '=', 'mst_resignation_menu_child.menu_child_id')
                    ->Where('mst_resignation_menu_parent.menu_parent_url','=',$request->path)
                    ->orWhere('mst_resignation_menu_child.menu_child_url','=',$request->path)
                    ->orWhere('mst_resignation_menu_grand_child.menu_grand_child_url','=',$request->path)
                    ->first();
    }
}