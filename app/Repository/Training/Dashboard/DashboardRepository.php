<?php

namespace App\Repository\Training\Dashboard;

use App\Repository\Training\Dashboard\Interfaces\DashboardInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Training\Training;
use App\Model\Training\TrainingParticipants;

class DashboardRepository implements DashboardInterfaces
{
    public static function GetMenuByUrl($request)
    {
        return DB::table('mst_training_menu_parent')
                    ->leftJoin('mst_training_menu_child', 'mst_training_menu_child.menu_parent_id', '=', 'mst_training_menu_parent.menu_parent_id')
                    ->leftJoin('mst_training_menu_grand_child', 'mst_training_menu_grand_child.menu_child_id', '=', 'mst_training_menu_child.menu_child_id')
                    ->where('mst_training_menu_parent.menu_parent_url','=',$request->path)
                    ->orWhere('mst_training_menu_child.menu_child_url','=',$request->path)
                    ->orWhere('mst_training_menu_grand_child.menu_grand_child_url','=',$request->path)
                    ->select('mst_training_menu_parent.menu_parent_id',
                            'mst_training_menu_parent.menu_parent_icon',
                            'mst_training_menu_parent.menu_parent_name',
                            'mst_training_menu_parent.menu_parent_url',
                            'mst_training_menu_child.menu_child_id',
                            'mst_training_menu_child.menu_child_name',
                            'mst_training_menu_child.menu_child_icon',
                            'mst_training_menu_child.menu_child_url',
                            'mst_training_menu_grand_child.menu_grand_child_id',
                            'mst_training_menu_grand_child.menu_grand_child_icon',
                            'mst_training_menu_grand_child.menu_grand_child_name',
                            'mst_training_menu_grand_child.menu_grand_child_url'
                            )
                    ->first();
    }

    public static function getTotalRequest($period_id)
    {
        return  Training::with(['TrainingApproval'])
            ->where('period_id',$period_id)
            ->count();
    }

    public static function getRejectCancel($period_id)
    {
        $query =  Training::with(['TrainingApproval']);
        $query->whereHas('TrainingApproval',function($q) use($period_id){
            $q->whereIn('training_status',['reject','cancel']);
        });
        $query->where('period_id',$period_id);
        return $query->count();
    }

    public static function getInprogress($period_id)
    {
        $query =  Training::with(['TrainingApproval']);
        $query->whereHas('TrainingApproval',function($q) use($period_id){
            $q->where('training_status','in_progress');
        });
        $query->where('period_id',$period_id);
        return $query->count();
    }

    public static function getApprove($period_id)
    {
        $query =  Training::with(['TrainingApproval']);
        $query->whereHas('TrainingApproval',function($q) use($period_id){
            $q->where('training_status','approve');
        });
        $query->where('period_id',$period_id);
        return $query->count();
    }

    public static function complete($period_id)
    {
        $query =  Training::with(['TrainingApproval']);
        $query->whereHas('TrainingApproval',function($q) use($period_id){
            $q->where('training_status','approve');
        });
        $query->where('period_id',$period_id);
        return $query->count();
    }

    public static function getPartipantFeedbackNull($period_id)
    {
        return  TrainingParticipants::with(['User','Feedback','Training','Training.TrainingApproval'])
            ->whereHas('Training.TrainingApproval',function($q){
                $q->where('training_status','approve');
            })
            ->whereHas('Training',function($q) use($period_id){
                $q->where('period_id',$period_id);
            })
            ->doesntHave('Feedback')
            ->count();

    }

    public static function getPartipantFeedback($period_id)
    {
        return  TrainingParticipants::with(['User','Feedback','Training','Training.TrainingApproval'])
            ->whereHas('Training.TrainingApproval',function($q){
                $q->where('training_status','approve');
            })
            ->whereHas('Training',function($q) use($period_id){
                $q->where('period_id',$period_id);
            })
            ->has('Feedback')
            ->count();

    }

    public static function getLevelRequest($period_id)
    {
        $query = "  SELECT
                        mmugg.grade_group_name AS level,
                        IFNULL(total.total,0) AS total
                    FROM mst_main_user AS mmu
                        LEFT JOIN mst_main_user_grade AS mmug
                            ON mmug.grade_id = mmu.grade_id
                        LEFT JOIN mst_main_user_grade_group AS mmugg
                            ON mmugg.grade_group_id = mmug.grade_group_id
                        left join (select
                                        mmugg.grade_group_id,
                                        count(mtlp.training_user_nik) AS total
                                    FROM mst_main_user AS mmu
                                        LEFT JOIN mst_main_user_grade AS mmug
                                            ON mmug.grade_id = mmu.grade_id
                                        LEFT JOIN mst_main_user_grade_group AS mmugg
                                            ON mmugg.grade_group_id = mmug.grade_group_id
                                        LEFT JOIN mst_training_list_participant AS mtlp
                                            ON mtlp.training_user_nik = mmu.user_nik 
                                        LEFT JOIN mst_training_list AS mtl
                                            ON mtl.training_id = mtlp.training_id
                                        LEFT JOIN mst_training_approval mta 
                                            ON mta.training_id = mtl.training_id 
                                    WHERE mtl.period_id = ".$period_id."
                                    AND mtl.deleted_at IS NULL
                                    AND mta.training_status in ('approve')
                                    GROUP by mmug.grade_group_id
                                    ) AS total 
                        on total.grade_group_id = mmugg.grade_group_id
                    GROUP by mmug.grade_group_id,total.total ";
        return DB::select($query);
    }

    public static function getDepartmentRequest($period_id)
    {
        $query = "  SELECT
                        mmd.department_name AS name,
                        IFNULL(total.value,0) AS value
                    FROM mst_main_user AS mmu
                        LEFT JOIN mst_main_department AS mmd
                            ON mmd.department_id = mmu.department_id 
                        LEFT join (select
                                        mmd.department_id ,
                                        count(mtlp.training_user_nik) AS value
                                    FROM mst_main_user AS mmu
                                        LEFT JOIN mst_main_department AS mmd 
                                            ON mmd.department_id = mmu.department_id 
                                        LEFT JOIN mst_training_list_participant AS mtlp
                                            ON mtlp.training_user_nik = mmu.user_nik 
                                        LEFT JOIN mst_training_list AS mtl
                                            ON mtl.training_id = mtlp.training_id
                                        LEFT JOIN mst_training_approval mta 
                                            ON mta.training_id = mtl.training_id 
                                    where mtl.period_id = ".$period_id."
                                    and mtl.deleted_at is null
                                    and mta.training_status in ('approve')
                                    GROUP by mmd.department_id
                                    ) AS total 
                        on total.department_id = mmd.department_id 
                    GROUP by mmd.department_id,total.value  ";
        return DB::select($query);
    }

    public static function getCategoryRequest($period_id)
    {
        $query = "SELECT 
                        mtc.category_name AS name,
                        IFNULL(total.total,0) AS value
                    FROM mst_training_category AS mtc 
                        LEFT JOIN (
                            SELECT 
                                mtl.category_id,
                                count(mtl.category_id) AS total
                            FROM mst_training_list AS mtl
                                LEFT JOIN mst_training_approval AS mta
                                    ON mta.training_id = mtl.training_id 
                            WHERE mtl.period_id = ".$period_id."
                            AND mta.training_status in ('approve')
                            GROUP BY(mtl.category_id)
                        ) AS total 
                            ON total.category_id = mtc.category_id 
                    WHERE mtc.deleted_at is null ";
        return DB::select($query);
    }

    public static function getFeedbackNUll($period_id)
    {
        return  TrainingParticipants::with(['User','User.Department','Feedback','Training','Training.TrainingApproval'])
            ->whereHas('Training.TrainingApproval',function($q){
                $q->where('training_status','approve');
            })
            ->whereHas('Training',function($q) use($period_id){
                $q->where('period_id',$period_id);
            })
            ->doesntHave('Feedback')
            ->get();
    }

    public static function getFeedback($period_id)
    {
        return  TrainingParticipants::with(['User','User.Department','Feedback','Training','Training.TrainingApproval'])
            ->whereHas('Training.TrainingApproval',function($q){
                $q->where('training_status','approve');
            })
            ->whereHas('Training',function($q) use($period_id){
                $q->where('period_id',$period_id);
            })
            ->get();
    }

    public static function getDetailParticipant($user_nik,$training_id)
    {
        return TrainingParticipants::with(['Training','User'])
            ->where('training_user_nik',$user_nik)
            ->where('training_id',$training_id)
            ->first();
    }
}