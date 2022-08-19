<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalMatrix extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_main_user_approval_matrix';
    protected $primaryKey = 'approval_id';
    protected $guarded = [];

    public static function GetData(){
        $query = "SELECT
                    am.approval_id,
                    mmu.user_nik,
                    mmu.user_name,
                    am1.approval_nik_1,
                    am1.user_name AS approval_name_1,
                    am2.approval_nik_2,
                    am2.user_name AS approval_name_2,
                    am3.approval_nik_3,
                    am3.user_name AS approval_name_3,
                    am4.approval_nik_4,
                    am4.user_name AS approval_name_4,
                    am5.approval_nik_5,
                    am5.user_name AS approval_name_5,
                    am6.approval_nik_6,
                    am6.user_name AS approval_name_6,
                    am7.approval_nik_ceo,
                    am7.user_name AS approval_name_ceo,
                    am8.approval_nik_hr,
                    am8.user_name AS approval_name_hr
                FROM mst_main_user AS mmu
                    INNER JOIN mst_main_user_approval_matrix AS am
                        ON am.user_nik = mmu.user_nik
                    LEFT JOIN (SELECT
                                    am.approval_nik_1,
                                    mmu.user_name
                                FROM mst_main_user AS mmu
                                    INNER JOIN mst_main_user_approval_matrix AS am
                                        ON am.approval_nik_1 = mmu.user_nik
                                GROUP BY am.approval_nik_1, mmu.user_name
                                ) AS am1
                        ON am1.approval_nik_1 = am.approval_nik_1
                    LEFT JOIN (SELECT
                                    am.approval_nik_2,
                                    mmu.user_name
                                FROM mst_main_user AS mmu
                                    INNER JOIN mst_main_user_approval_matrix AS am
                                        ON am.approval_nik_2 = mmu.user_nik
                                GROUP BY am.approval_nik_2, mmu.user_name
                                ) AS am2
                        ON am2.approval_nik_2 = am.approval_nik_2
                    LEFT JOIN (SELECT
                                    am.approval_nik_3,
                                    mmu.user_name
                                FROM mst_main_user AS mmu
                                    INNER JOIN mst_main_user_approval_matrix AS am
                                        ON am.approval_nik_3 = mmu.user_nik
                                GROUP BY am.approval_nik_3, mmu.user_name
                                ) AS am3
                        ON am3.approval_nik_3 = am.approval_nik_3
                    LEFT JOIN (SELECT
                                    am.approval_nik_4,
                                    mmu.user_name
                                FROM mst_main_user AS mmu
                                    INNER JOIN mst_main_user_approval_matrix AS am
                                        ON am.approval_nik_4 = mmu.user_nik
                                GROUP BY am.approval_nik_4, mmu.user_name
                                ) AS am4
                        ON am4.approval_nik_4 = am.approval_nik_4
                    LEFT JOIN (SELECT
                                    am.approval_nik_5,
                                    mmu.user_name
                                FROM mst_main_user AS mmu
                                    INNER JOIN mst_main_user_approval_matrix AS am
                                        ON am.approval_nik_5 = mmu.user_nik
                                GROUP BY am.approval_nik_5, mmu.user_name
                                ) AS am5
                        ON am5.approval_nik_5 = am.approval_nik_5
                    LEFT JOIN (SELECT
                                    am.approval_nik_6,
                                    mmu.user_name
                                FROM mst_main_user AS mmu
                                    INNER JOIN mst_main_user_approval_matrix AS am
                                        ON am.approval_nik_6 = mmu.user_nik
                                GROUP BY am.approval_nik_6, mmu.user_name
                                ) AS am6
                        ON am6.approval_nik_6 = am.approval_nik_6
                    LEFT JOIN (SELECT
                                    am.approval_nik_ceo,
                                    mmu.user_name
                                FROM mst_main_user AS mmu
                                    INNER JOIN mst_main_user_approval_matrix AS am
                                        ON am.approval_nik_ceo = mmu.user_nik
                                GROUP BY am.approval_nik_ceo, mmu.user_name
                                ) AS am7
                        ON am7.approval_nik_ceo = am.approval_nik_ceo
                    LEFT JOIN (SELECT
                                    am.approval_nik_hr,
                                    mmu.user_name
                                FROM mst_main_user AS mmu
                                    INNER JOIN mst_main_user_approval_matrix AS am
                                        ON am.approval_nik_hr = mmu.user_nik
                                GROUP BY am.approval_nik_hr, mmu.user_name
                                ) AS am8
                        ON am8.approval_nik_hr = am.approval_nik_hr
                WHERE am.deleted_at IS NULL AND mmu.deleted_at IS NULL";
        return DB::select($query);

    }

    public function User(){
        return $this->belongsTo('App\Model\User','user_nik','user_nik');
    }

    public function Resign(){
        return $this->hasOne('namespace App\Model\Resignation\Resign','user_nik','user_nik');
    }
}
