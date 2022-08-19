<?php

namespace App\Repository\Resignation\Report;

use App\Repository\Resignation\Report\Interfaces\ReportInterfaces;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportInterfaces
{
    public function AtritionRate($request)
    {
        if($request->type == 'period'){
            $period = explode('-',$request->period_name);
            $paramsHC = "AND DATE_FORMAT(user.user_join_date, '%Y-%m') <= '".$period[1]."-03'"; // $period[1] e.g 2019-2020 karena data tahun yg diambil tahun yang terakhir
            $paramsResign = "AND DATE_FORMAT(resign.resign_date, '%Y-%m')
                                BETWEEN '".$period[0]."-04' AND '".$period[1]."-03'"; // $params[1] e.g 2019-2020 karena data tahun yg diambil tahun yang terakhir"
        }else{
            $month_number = date('m', strtotime($request->month_name));
            $paramsHC = "AND user.user_join_date <= '".$request->year_name."-".$month_number."'";
            $paramsResign = "AND MONTH(resign.resign_date) = '".$month_number."'
                            AND YEAR(resign.resign_date) = '".$request->year_name."'";
        }

        $query = "  SELECT 	
                        grade_group.grade_group_name, 
                        count(nos.user_nik) as total_resign,
                        hc.total_hc
                    FROM mst_main_user AS user
                        INNER JOIN mst_main_user_grade AS grade
                            ON grade.grade_id = user.grade_id
                            AND grade.deleted_at IS NULL
                        INNER JOIN mst_main_user_grade_group AS grade_group
                            ON grade_group.grade_group_id = grade.grade_group_id
                            AND grade_group.deleted_at IS NULL
                        LEFT JOIN mst_resignation_resign_list AS resign
                            ON resign.user_nik = user.user_nik
                            AND resign.resign_status = 'approve'
                            AND resign.resign_clearance_status = 'approve'       
                        LEFT JOIN (SELECT 
                                        grade_group.grade_group_id, 
                                        count(*) AS total_hc 
                                    FROM mst_main_user AS user
                                        INNER JOIN mst_main_user_grade AS grade
                                            ON user.grade_id = grade.grade_id
                                        INNER JOIN mst_main_user_grade_group AS grade_group
                                            ON grade_group.grade_group_id = grade.grade_group_id
                                        INNER JOIN mst_main_user_type AS type
                                                on type.type_id = user.type_id
                                    WHERE 1=1   
                                    ".$paramsHC."
                                    group by grade_group.grade_group_name, grade_group.grade_group_id
                                    ) AS hc
                            ON hc.grade_group_id = grade_group.grade_group_id
                        LEFT JOIN (	SELECT user.user_nik
                                    FROM mst_resignation_resign_list AS resign
                                        LEFT JOIN mst_main_user AS user
                                            ON resign.user_nik = user.user_nik
                                            AND resign.resign_status = 'approve'
                                            AND resign.resign_clearance_status = 'approve'
                                            WHERE 1=1 
                                            ".$paramsResign.") AS nos
                        ON nos.user_nik = user.user_nik
                    GROUP BY  grade_group.grade_group_name,hc.total_hc
                    UNION
                    SELECT 	
                        CONCAT('Grand Total') AS grade_group_name,
                        count(nos.user_nik) AS total_resign,
                        count(hc.total_hc)
                    FROM mst_main_user AS user
                        INNER JOIN mst_main_user_grade AS grade
                            ON grade.grade_id = user.grade_id
                            AND grade.deleted_at IS NULL
                        INNER JOIN mst_main_user_grade_group AS grade_group
                            ON grade_group.grade_group_id = grade.grade_group_id
                            AND grade_group.deleted_at IS NULL
                        LEFT JOIN mst_resignation_resign_list AS resign
                            ON resign.user_nik = user.user_nik
                            AND resign.resign_status = 'approve'
                            AND resign.resign_clearance_status = 'approve'       
                        LEFT JOIN (SELECT 
                                        grade_group.grade_group_id, 
                                        count(*) AS total_hc 
                                    FROM mst_main_user AS user
                                        INNER JOIN mst_main_user_grade AS grade
                                            ON user.grade_id = grade.grade_id
                                        INNER JOIN mst_main_user_grade_group AS grade_group
                                            on grade_group.grade_group_id = grade.grade_group_id
                                        INNER JOIN mst_main_user_type AS type
                                                on type.type_id = user.type_id
                                    WHERE 1=1   
                                    ".$paramsHC."
                                    group by grade_group.grade_group_name, grade_group.grade_group_id 
                                    ) AS hc
                            ON hc.grade_group_id = grade_group.grade_group_id
                        left join (	select user.user_nik
                                    from mst_resignation_resign_list AS resign
                                        LEFT JOIN mst_main_user AS user
                                            ON resign.user_nik = user.user_nik
                                            AND resign.resign_status = 'approve'
                                            AND resign.resign_clearance_status = 'approve'
                                            WHERE 1=1 
                                            ".$paramsResign.")AS nos
                            on nos.user_nik = user.user_nik";
        return DB::select($query);
    }

    public function ARTalent($request)
    {
        $queryCondition = $this->QueryCondition($request);
        $query = "  SELECT 	
                            grade_group.grade_group_name, 
                            count(talent.talent) as total_talent,
                            count(nontalent.talent) as total_non_talent
                    FROM mst_main_user as user
                        INNER JOIN mst_main_user_grade as grade
                            ON grade.grade_id = user.grade_id
                            AND grade.deleted_at IS NULL
                        INNER JOIN mst_main_user_grade_group as grade_group
                            ON grade_group.grade_group_id = grade.grade_group_id
                            AND grade_group.deleted_at IS NULL
                        LEFT JOIN mst_resignation_resign_list as resign
                            ON resign.user_nik = user.user_nik
                            AND resign.resign_status = 'approve'
        				    AND resign.resign_clearance_status = 'approve'       
                        LEFT JOIN (select user.user_nik,resign.resign_user_talent as talent
                                    from mst_resignation_resign_list as resign
                                        LEFT JOIN mst_main_user as user
                                            ON resign.user_nik = user.user_nik
                                            AND resign.resign_status = 'approve'
        				                    AND resign.resign_clearance_status = 'approve'
                                    where resign.resign_user_talent = 'talent'
                                    ".$queryCondition.") as talent
                            ON talent.user_nik = user.user_nik
                        LEFT JOIN (select user.user_nik,resign.resign_user_talent as talent
                                    from mst_resignation_resign_list as resign
                                        LEFT JOIN mst_main_user as user
                                            ON resign.user_nik = user.user_nik
                                            AND resign.resign_status = 'approve'
        				                    AND resign.resign_clearance_status = 'approve'
                                    where resign.resign_user_talent = 'non-talent'
                                    ".$queryCondition.") as nontalent
                            ON nontalent.user_nik = user.user_nik
                    GROUP BY  grade_group.grade_group_name
                    UNION
                    SELECT 	
                            CONCAT('Grand Total') AS grade_group_name, 
                            count(talent.talent) as total_talent,
                            count(nontalent.talent) as total_non_talent
                    FROM mst_main_user as user
                        INNER JOIN mst_main_user_grade as grade
                            ON grade.grade_id = user.grade_id
                            AND grade.deleted_at IS NULL
                        INNER JOIN mst_main_user_grade_group as grade_group
                            ON grade_group.grade_group_id = grade.grade_group_id
                            AND grade_group.deleted_at IS NULL
                        LEFT JOIN mst_resignation_resign_list as resign
                            ON resign.user_nik = user.user_nik
                            AND resign.resign_status = 'approve'
        				    AND resign.resign_clearance_status = 'approve'       
                        LEFT JOIN (select user.user_nik,resign.resign_user_talent as talent
                                    from mst_resignation_resign_list as resign
                                        LEFT JOIN mst_main_user as user
                                            ON resign.user_nik = user.user_nik
                                            AND resign.resign_status = 'approve'
        				                    AND resign.resign_clearance_status = 'approve'
                                    where resign.resign_user_talent = 'talent'
                                    ".$queryCondition.") as talent
                            ON talent.user_nik = user.user_nik
                        LEFT JOIN (select user.user_nik,resign.resign_user_talent as talent
                                    from mst_resignation_resign_list as resign
                                        LEFT JOIN mst_main_user as user
                                            ON resign.user_nik = user.user_nik
                                            AND resign.resign_status = 'approve'
        				                    AND resign.resign_clearance_status = 'approve'
                                    where resign.resign_user_talent = 'non-talent'
                                    ".$queryCondition.") as nontalent
                            ON nontalent.user_nik = user.user_nik";
        return DB::select($query);
    }
    
    public function ARInitiation($request)
    {
        $queryCondition = $this->QueryCondition($request);
        $query = "  SELECT 	
                        grade_group.grade_group_name, 
                        count(volunteer.initation) as total_volunteer,
                        count(nonvolunteer.initation) as total_non_volunteer
                    FROM mst_main_user as user
                        INNER JOIN mst_main_user_grade as grade
                            ON grade.grade_id = user.grade_id
                            AND grade.deleted_at IS NULL
                        INNER JOIN mst_main_user_grade_group as grade_group
                            ON grade_group.grade_group_id = grade.grade_group_id
                            AND grade_group.deleted_at IS NULL
                        LEFT JOIN mst_resignation_resign_list as resign
                            ON resign.user_nik = user.user_nik
                            AND resign.resign_status = 'approve'
                            AND resign.resign_clearance_status = 'approve'       
                        LEFT JOIN (select user.user_nik,resign.resign_user_initation as initation
                                    from mst_resignation_resign_list as resign
                                        LEFT JOIN mst_main_user as user
                                            ON resign.user_nik = user.user_nik
                                            AND resign.resign_status = 'approve'
                                            AND resign.resign_clearance_status = 'approve'
                                    where resign.resign_user_initation = 'volunteer'
                                    ".$queryCondition.") as volunteer
                            ON volunteer.user_nik = user.user_nik
                        LEFT JOIN (select user.user_nik,resign.resign_user_initation as initation
                                    from mst_resignation_resign_list as resign
                                        LEFT JOIN mst_main_user as user
                                            ON resign.user_nik = user.user_nik
                                            AND resign.resign_status = 'approve'
                                            AND resign.resign_clearance_status = 'approve'
                                    where resign.resign_user_initation = 'non-volunteer'
                                    ".$queryCondition.") as nonvolunteer
                            ON nonvolunteer.user_nik = user.user_nik
                    GROUP BY  grade_group.grade_group_name
                    UNION
                    SELECT 	
                        CONCAT('Grand Total') AS grade_group_name, 
                        count(volunteer.initation) as total_volunteer,
                        count(nonvolunteer.initation) as total_non_volunteer
                    FROM mst_main_user as user
                        INNER JOIN mst_main_user_grade as grade
                            ON grade.grade_id = user.grade_id
                            AND grade.deleted_at IS NULL
                        INNER JOIN mst_main_user_grade_group as grade_group
                            ON grade_group.grade_group_id = grade.grade_group_id
                            AND grade_group.deleted_at IS NULL
                        LEFT JOIN mst_resignation_resign_list as resign
                            ON resign.user_nik = user.user_nik
                            AND resign.resign_status = 'approve'
                            AND resign.resign_clearance_status = 'approve'       
                        LEFT JOIN (select user.user_nik,resign.resign_user_initation as initation
                                    from mst_resignation_resign_list as resign
                                        LEFT JOIN mst_main_user as user
                                            ON resign.user_nik = user.user_nik
                                            AND resign.resign_status = 'approve'
                                            AND resign.resign_clearance_status = 'approve'
                                    where resign.resign_user_initation = 'volunteer'
                                    ".$queryCondition.") as volunteer
                            ON volunteer.user_nik = user.user_nik
                        LEFT JOIN (select user.user_nik,resign.resign_user_initation as initation
                                    from mst_resignation_resign_list as resign
                                        LEFT JOIN mst_main_user as user
                                            ON resign.user_nik = user.user_nik
                                            AND resign.resign_status = 'approve'
                                            AND resign.resign_clearance_status = 'approve'
                                    where resign.resign_user_initation = 'non-volunteer'
                                    ".$queryCondition.") as nonvolunteer
                            ON nonvolunteer.user_nik = user.user_nik";
        return DB::select($query);
    }

    public function QueryCondition($request)
    {
        $queryCondition = '';
        if($request->type == 'period'):
            $period = explode('-',$request->period_name); // memecah period_name karena formatnya e.g 2020 - 2021
            $queryCondition = "AND DATE_FORMAT(resign.resign_date, '%Y-%m')
                                BETWEEN '".$period[0]."-04' AND '".$period[1]."-03'";
        elseif ($request->type == 'month') :
            $month_number = date('m', strtotime($request->month_name));
            $queryCondition = "AND MONTH(resign.resign_date) = '".$month_number."'
                                AND YEAR(resign.resign_date) = '".$request->year_name."'";
        elseif ($request->type == 'quarter'):
            $period = explode('-',$request->period_name); // memecah period_name karena formatnya e.g 2020 - 2021
            $queryCondition = "AND DATE_FORMAT(resign.resign_date, '%Y-%m')";
            if ($request->quarter_name == 'Q1') : 
                $queryCondition .= "BETWEEN '".$period[0]."-04' AND '".$period[0]."-06'";
            elseif ($request->quarter_name == 'Q2'):
                $queryCondition .= "BETWEEN '".$period[0]."-07' AND '".$period[0]."-09'";
            elseif ($request->quarter_name == 'Q3'):
                $queryCondition .= "BETWEEN '".$period[0]."-10' AND '".$period[0]."-12'";
            elseif ($request->quarter_name == 'Q4'):
                $queryCondition .= "BETWEEN '".$period[1]."-01' AND '".$period[1]."-03'";
            endif;
        endif;

        return $queryCondition;
    }

    public function feedback($request)
    {
        $queryCondition = $this->QueryCondition($request);
        $query = "  SELECT 
                        user.user_name,
                        department.department_name,
                        feedback.* 
                    FROM mst_resignation_resign_list AS resign
                        INNER JOIN mst_resignation_feedback AS feedback
                            ON resign.resign_id = feedback.resign_id
                        INNER JOIN mst_main_user AS user
                            ON user.user_nik = resign.user_nik
                        INNER JOIN mst_main_department AS department 
                            ON department.department_id = user.department_id 
                    WHERE 1 = 1
                    ".$queryCondition;
        return DB::select($query);
    }
}