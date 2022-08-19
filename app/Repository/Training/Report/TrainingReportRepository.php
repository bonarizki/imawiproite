<?php

namespace App\Repository\Training\Report;

use App\Repository\Training\Report\Interfaces\TrainingReportInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Training\TrainingParticipants;

clASs TrainingReportRepository implements TrainingReportInterfaces
{
    public functiON ReportTopic($request)
    {
        $queryCondition = $this->queryCondition($request);
        $query = "  SELECT
                        MONTH(mtl.training_date_request) AS bulan,
                        YEAR(mtl.training_date_request) AS tahun,
                        mtl.training_topic,
                        mmd.department_name,
                        count(mmd.department_name) AS participant,
                        mtl.training_total 
                    FROM mst_training_list AS mtl
                        LEFT JOIN mst_training_list_participant AS mtlp
                            ON mtlp.training_id = mtl.training_id
                        LEFT JOIN mst_main_user AS mmu
                            ON mmu.user_nik = mtlp.training_user_nik
                        LEFT JOIN mst_main_department AS mmd
                            ON mmd.department_id = mmu.department_id
                            LEFT JOIN mst_training_approval AS mta
                                ON mta.training_id = mtl.training_id 
                    WHERE 1=1
                    AND mtl.deleted_at IS NULL
                    AND mta.training_status = 'approve'
                    $queryCondition
                    GROUP BY 
                        mmu.department_id,
                        mtl.training_topic,
                        mmd.department_name,
                        mtl.training_participants,
                        MONTH(mtl.training_date_request),
                        YEAR(mtl.training_date_request),
                        mtl.training_total 
                    ORDER BY mtl.training_topic ASC";
        return DB::select($query);
    }

    public functiON ReportParticipant($request)
    {
        /** menentukan limit user join date */
        if($request->type == 'period'){
            $period = explode('-',$request->period_name);
            $user_join = "AND DATE_FORMAT(mmu.user_join_date, '%Y-%m') <= '$period[1]-03'"; // $period[1] e.g 2019-$period[0] karena data tahun yg diambil tahun yang terakhir
        }else{
            $mONth_number = date('m', strtotime($request->mONth_name));
            $user_join = "AND mmu.user_join_date <= '$request->year_name - $mONth_number'";
        }

        /** Condition query (period or mONth) */
        $queryCondition = $this->queryCondition($request);
        $query = "  SELECT 
                        mmd.department_name,
                        IFNULL(total_ws.total_karyawan,0) AS total_karyawan_ws,
                        IFNULL(total_ws.total_participant,0) AS total_participant_ws,
                        IFNULL(total_sm.total_karyawan,0) AS total_karyawan_sm,
                        IFNULL(total_sm.total_participant,0) AS total_participant_sm,
                        IFNULL(total_ms.total_karyawan,0) AS total_karyawan_ms,
                        IFNULL(total_ms.total_participant,0) AS total_participant_ms,
                        IFNULL(total.total_karyawan,0) AS total_karyawan,
                        IFNULL(total.total_participant,0) AS total_participant
                    FROM mst_main_department AS mmd
                        -- ws
                        LEFT JOIN (
                            SELECT 
                                mmd.department_id,
                                total_karyawan.total AS total_karyawan,
                                IFNULL(total_participant.total,0) AS total_participant 
                            FROM mst_main_department AS mmd
                                LEFT JOIN (
                                            SELECT
                                                mmd.department_id,
                                                count(mmu.user_nik) AS total
                                            FROM mst_main_department AS mmd 
                                                LEFT JOIN mst_main_user AS mmu
                                                    ON mmu.department_id = mmd.department_id
                                                    $user_join
                                                    AND mmu.deleted_at IS NULL
                                                LEFT JOIN mst_main_user_grade AS mmug
                                                    ON mmug.grade_id = mmu.grade_id
                                                LEFT JOIN mst_main_user_grade_group AS mmugg
                                                    ON mmugg.grade_group_id = mmug.grade_group_id
                                            WHERE mmugg.grade_group_id BETWEEN '1' AND '3'
                                            GROUP BY
                                                mmd.department_id
                                        ) AS total_karyawan
                                    ON total_karyawan.department_id = mmd.department_id
                                LEFT JOIN (
                                            SELECT
                                                mmd.department_id,
                                                count(mtlp.training_user_nik) AS total
                                            FROM mst_main_department AS mmd 
                                                LEFT JOIN mst_main_user AS mmu
                                                    ON mmu.department_id = mmd.department_id
                                                    $user_join
                                                    AND mmu.deleted_at IS NULL
                                                LEFT JOIN mst_main_user_grade AS mmug
                                                    ON mmug.grade_id = mmu.grade_id
                                                LEFT JOIN mst_main_user_grade_group AS mmugg
                                                    ON mmugg.grade_group_id = mmug.grade_group_id
                                                LEFT JOIN mst_training_list_participant AS mtlp
                                                    ON mtlp.training_user_nik = mmu.user_nik
                                                LEFT JOIN mst_training_approval AS mta
                                                    ON mta.training_id = mtlp.training_id 
                                                LEFT JOIN mst_training_list AS mtl
								                    ON mtl.training_id = mtlp.training_id 
                                            WHERE
                                            1=1
                                            AND mmugg.grade_group_id BETWEEN '1' AND '3'
                                            AND mta.training_status = 'approve'
                                            $queryCondition
                                            GROUP BY
                                                mmd.department_id
                                        ) AS total_participant 
                                    ON total_participant.department_id = mmd.department_id 
                        ) AS total_ws
                            ON total_ws.department_id = mmd.department_id 
                        -- sm
                        LEFT JOIN (
                            SELECT 
                                mmd.department_id,
                                total_karyawan.total AS total_karyawan,
                                IFNULL(total_participant.total,0) AS total_participant 
                            FROM mst_main_department AS mmd
                                LEFT JOIN (
                                            SELECT
                                                mmd.department_id,
                                                count(mmu.user_nik) AS total
                                            FROM mst_main_department AS mmd 
                                                LEFT JOIN mst_main_user AS mmu
                                                    ON mmu.department_id = mmd.department_id
                                                    $user_join
                                                    AND mmu.deleted_at IS NULL
                                                LEFT JOIN mst_main_user_grade AS mmug
                                                    ON mmug.grade_id = mmu.grade_id
                                                LEFT JOIN mst_main_user_grade_group AS mmugg
                                                    ON mmugg.grade_group_id = mmug.grade_group_id
                                            WHERE mmugg.grade_group_id BETWEEN '4' AND '5'
                                            GROUP BY
                                                mmd.department_id
                                        ) AS total_karyawan
                                    ON total_karyawan.department_id = mmd.department_id
                                LEFT JOIN (
                                            SELECT
                                                mmd.department_id,
                                                count(mtlp.training_user_nik) AS total
                                            FROM mst_main_department AS mmd 
                                                LEFT JOIN mst_main_user AS mmu
                                                    ON mmu.department_id = mmd.department_id
                                                    $user_join
                                                    AND mmu.deleted_at IS NULL
                                                LEFT JOIN mst_main_user_grade AS mmug
                                                    ON mmug.grade_id = mmu.grade_id
                                                LEFT JOIN mst_main_user_grade_group AS mmugg
                                                    ON mmugg.grade_group_id = mmug.grade_group_id
                                                LEFT JOIN mst_training_list_participant AS mtlp
                                                    ON mtlp.training_user_nik = mmu.user_nik
                                                LEFT JOIN mst_training_approval AS mta
                                                    ON mta.training_id = mtlp.training_id 
                                                LEFT JOIN mst_training_list AS mtl
                                                    ON mtl.training_id = mtlp.training_id 
                                            WHERE
                                            1=1
                                            AND mmugg.grade_group_id BETWEEN '4' AND '5'
                                            AND mta.training_status = 'approve'
                                            $queryCondition
                                            GROUP BY
                                                mmd.department_id
                                        ) AS total_participant 
                                    ON total_participant.department_id = mmd.department_id 
                        ) AS total_sm
                            ON total_sm.department_id = mmd.department_id
                        -- ms
                        LEFT JOIN (
                            SELECT 
                                mmd.department_id,
                                total_karyawan.total AS total_karyawan,
                                IFNULL(total_participant.total,0) AS total_participant 
                            FROM mst_main_department AS mmd
                                LEFT JOIN (
                                            SELECT
                                                mmd.department_id,
                                                count(mmu.user_nik) AS total
                                            FROM mst_main_department AS mmd 
                                                LEFT JOIN mst_main_user AS mmu
                                                    ON mmu.department_id = mmd.department_id
                                                    $user_join
                                                    AND mmu.deleted_at IS NULL
                                                LEFT JOIN mst_main_user_grade AS mmug
                                                    ON mmug.grade_id = mmu.grade_id
                                                LEFT JOIN mst_main_user_grade_group AS mmugg
                                                    ON mmugg.grade_group_id = mmug.grade_group_id
                                            WHERE mmugg.grade_group_id BETWEEN '6' AND '7'
                                            GROUP BY
                                                mmd.department_id
                                        ) AS total_karyawan
                                    ON total_karyawan.department_id = mmd.department_id
                                LEFT JOIN (
                                            SELECT
                                                mmd.department_id,
                                                count(mtlp.training_user_nik) AS total
                                            FROM mst_main_department AS mmd 
                                                LEFT JOIN mst_main_user AS mmu
                                                    ON mmu.department_id = mmd.department_id
                                                    $user_join
                                                    AND mmu.deleted_at IS NULL
                                                LEFT JOIN mst_main_user_grade AS mmug
                                                    ON mmug.grade_id = mmu.grade_id
                                                LEFT JOIN mst_main_user_grade_group AS mmugg
                                                    ON mmugg.grade_group_id = mmug.grade_group_id
                                                LEFT JOIN mst_training_list_participant AS mtlp
                                                    ON mtlp.training_user_nik = mmu.user_nik
                                                LEFT JOIN mst_training_approval AS mta
                                                    ON mta.training_id = mtlp.training_id 
                                                LEFT JOIN mst_training_list AS mtl
                                                    ON mtl.training_id = mtlp.training_id 
                                            WHERE
                                            1=1
                                            AND mmugg.grade_group_id BETWEEN '6' AND '7'
                                            AND mta.training_status = 'approve'
                                            $queryCondition
                                            GROUP BY
                                                mmd.department_id
                                        ) AS total_participant 
                                    ON total_participant.department_id = mmd.department_id 
                        ) AS total_ms
                            ON total_ms.department_id = mmd.department_id
                        -- all
                        LEFT JOIN (
                            SELECT 
                                mmd.department_id,
                                total_karyawan.total AS total_karyawan,
                                IFNULL(total_participant.total,0) AS total_participant 
                            FROM mst_main_department AS mmd
                                LEFT JOIN (
                                            SELECT
                                                mmd.department_id,
                                                count(mmu.user_nik) AS total
                                            FROM mst_main_department AS mmd 
                                                LEFT JOIN mst_main_user AS mmu
                                                    ON mmu.department_id = mmd.department_id
                                                    $user_join
                                                    AND mmu.deleted_at IS NULL
                                                LEFT JOIN mst_main_user_grade AS mmug
                                                    ON mmug.grade_id = mmu.grade_id
                                                LEFT JOIN mst_main_user_grade_group AS mmugg
                                                    ON mmugg.grade_group_id = mmug.grade_group_id
                                            GROUP BY
                                                mmd.department_id
                                        ) AS total_karyawan
                                    ON total_karyawan.department_id = mmd.department_id
                                LEFT JOIN (
                                            SELECT
                                                mmd.department_id,
                                                count(mtlp.training_user_nik) AS total
                                            FROM mst_main_department AS mmd 
                                                LEFT JOIN mst_main_user AS mmu
                                                    ON mmu.department_id = mmd.department_id
                                                    $user_join
                                                    AND mmu.deleted_at IS NULL
                                                LEFT JOIN mst_main_user_grade AS mmug
                                                    ON mmug.grade_id = mmu.grade_id
                                                LEFT JOIN mst_main_user_grade_group AS mmugg
                                                    ON mmugg.grade_group_id = mmug.grade_group_id
                                                LEFT JOIN mst_training_list_participant AS mtlp
                                                    ON mtlp.training_user_nik = mmu.user_nik
                                                LEFT JOIN mst_training_approval AS mta
                                                    ON mta.training_id = mtlp.training_id
                                                LEFT JOIN mst_training_list AS mtl
                                                    ON mtl.training_id = mtlp.training_id
                                            WHERE
                                            1=1
                                            AND mta.training_status = 'approve'
                                            $queryCondition
                                            GROUP BY
                                                mmd.department_id
                                        ) AS total_participant 
                                    ON total_participant.department_id = mmd.department_id 
                        ) AS total
                            ON total.department_id = mmd.department_id";
        return DB::select($query);
    }

    public functiON ReportMandays($request)
    {
        $period = explode('-',$request->period_name);
        /**
         * [0] untuk q1 - q3
         * [1] untuk q4
         */
        $query = "  SELECT 
                        *
                    FROM (
                        SELECT
                            'NON Manager' AS grade,
                            COALESCE(q1.total_karyawan_q1,0) AS total_karyawan_q1,
                            COALESCE(q1.total_participant_q1,0) AS total_participant_q1,
                            COALESCE(q1.total_hari_q1,0) AS total_hari_q1,
                            COALESCE(q1.total_mandays_q1,0) AS total_mandays_q1,
                            COALESCE(q2.total_karyawan_q2,0) AS total_karyawan_q2,
                            COALESCE(q2.total_participant_q2,0) AS total_participant_q2,
                            COALESCE(q2.total_hari_q2,0) AS total_hari_q2,
                            COALESCE(q2.total_mandays_q2,0) AS total_mandays_q2,
                            COALESCE(q3.total_karyawan_q3,0) AS total_karyawan_q3,
                            COALESCE(q3.total_participant_q3,0) AS total_participant_q3,
                            COALESCE(q3.total_hari_q3,0) AS total_hari_q3,
                            COALESCE(q3.total_mandays_q3,0) AS total_mandays_q3,
                            COALESCE(q4.total_karyawan_q4,0) AS total_karyawan_q4,
                            COALESCE(q4.total_participant_q4,0) AS total_participant_q4,
                            COALESCE(q4.total_hari_q4,0) AS total_hari_q4,
                            COALESCE(q4.total_mandays_q4,0) AS total_mandays_q4
                        FROM 
                            (
                                SELECT
                                    (
                                        SELECT
                                            count(mmu.user_nik) AS total_karyawan
                                        FROM  mst_main_user AS mmu
                                            LEFT JOIN mst_main_user_grade AS mmug
                                                ON mmug.grade_id = mmu.grade_id
                                            LEFT JOIN mst_main_user_grade_group AS mmugg
                                                ON mmugg.grade_group_id = mmug.grade_group_id
                                        WHERE 1=1
                                        AND mmugg.grade_group_id BETWEEN 1 AND 5
                                        AND DATE_FORMAT(mmu.user_join_date, '%Y-%m') <= '$period[0]-06'
                                        AND mmu.deleted_at IS NULL
                                    ) AS total_karyawan_q1,
                                    sum(total_participant) AS total_participant_q1,
                                    sum(total_hari) AS total_hari_q1,
                                    (sum(total_participant) * sum(total_hari)) AS total_mandays_q1
                                FROM (
                                    SELECT
                                        count(mtlp.training_user_nik) total_participant,
                                        mtl.training_total AS total_hari
                                    FROM mst_main_user AS mmu
                                        LEFT JOIN mst_main_user_grade AS mmug
                                            ON mmug.grade_id = mmu.grade_id 
                                        LEFT JOIN mst_main_user_grade_group AS mmugg
                                            ON mmugg.grade_group_id = mmug.grade_group_id
                                        LEFT JOIN mst_training_list_participant AS mtlp
                                            ON mtlp.training_user_nik = mmu.user_nik
                                        LEFT JOIN mst_training_list AS mtl
                                            ON mtl.training_id = mtlp.training_id 
                                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                                BETWEEN '$period[0]-04' AND '$period[0]-06'
                                        LEFT JOIN mst_training_approval AS mta
                                            ON mta.training_id = mtl.training_id 
                                    where mmugg.grade_group_id BETWEEN 1 AND 5
                                    AND mmu.deleted_at IS NULL
                                    AND mta.training_status = 'approve'
                                    GROUP BY mtl.training_id
                                ) AS q1
                            )AS q1
                            CROSS JOIN (
                                SELECT
                                    (
                                        SELECT
                                            count(mmu.user_nik) AS total_karyawan
                                        FROM  mst_main_user AS mmu
                                            LEFT JOIN mst_main_user_grade AS mmug
                                                ON mmug.grade_id = mmu.grade_id
                                            LEFT JOIN mst_main_user_grade_group AS mmugg
                                                ON mmugg.grade_group_id = mmug.grade_group_id
                                        WHERE 1=1
                                        AND mmugg.grade_group_id BETWEEN 1 AND 5
                                        AND DATE_FORMAT(mmu.user_join_date, '%Y-%m') <= '$period[0]-09'
                                        AND mmu.deleted_at IS NULL
                                    ) AS total_karyawan_q2,
                                    sum(total_participant) AS total_participant_q2,
                                    sum(total_hari) AS total_hari_q2,
                                    (sum(total_participant) * sum(total_hari)) AS total_mandays_q2
                                FROM (
                                    SELECT
                                        count(mtlp.training_user_nik) total_participant,
                                        mtl.training_total AS total_hari
                                    FROM mst_main_user AS mmu
                                        LEFT JOIN mst_main_user_grade AS mmug
                                            ON mmug.grade_id = mmu.grade_id 
                                        LEFT JOIN mst_main_user_grade_group AS mmugg
                                            ON mmugg.grade_group_id = mmug.grade_group_id
                                        LEFT JOIN mst_training_list_participant AS mtlp
                                            ON mtlp.training_user_nik = mmu.user_nik
                                        LEFT JOIN mst_training_list AS mtl
                                            ON mtl.training_id = mtlp.training_id 
                                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                                BETWEEN '$period[0]-07' AND '$period[0]-09'
                                        LEFT JOIN mst_training_approval AS mta
                                            ON mta.training_id = mtl.training_id 
                                    where mmugg.grade_group_id BETWEEN 1 AND 5
                                    AND mmu.deleted_at IS NULL
                                    AND mta.training_status = 'approve'
                                    GROUP BY mtl.training_id
                                ) AS q2
                            )AS q2
                            CROSS JOIN (
                                SELECT
                                    (
                                        SELECT
                                            count(mmu.user_nik) AS total_karyawan
                                        FROM  mst_main_user AS mmu
                                            LEFT JOIN mst_main_user_grade AS mmug
                                                ON mmug.grade_id = mmu.grade_id
                                            LEFT JOIN mst_main_user_grade_group AS mmugg
                                                ON mmugg.grade_group_id = mmug.grade_group_id
                                        WHERE 1=1
                                        AND mmugg.grade_group_id BETWEEN 1 AND 5
                                        AND DATE_FORMAT(mmu.user_join_date, '%Y-%m') <= '$period[0]-12'
                                        AND mmu.deleted_at IS NULL
                                    ) AS total_karyawan_q3,
                                    sum(total_participant) AS total_participant_q3,
                                    sum(total_hari) AS total_hari_q3,
                                    (sum(total_participant) * sum(total_hari)) AS total_mandays_q3
                                FROM (
                                    SELECT
                                        count(mtlp.training_user_nik) total_participant,
                                        mtl.training_total AS total_hari
                                    FROM mst_main_user AS mmu
                                        LEFT JOIN mst_main_user_grade AS mmug
                                            ON mmug.grade_id = mmu.grade_id 
                                        LEFT JOIN mst_main_user_grade_group AS mmugg
                                            ON mmugg.grade_group_id = mmug.grade_group_id
                                        LEFT JOIN mst_training_list_participant AS mtlp
                                            ON mtlp.training_user_nik = mmu.user_nik
                                        LEFT JOIN mst_training_list AS mtl
                                            ON mtl.training_id = mtlp.training_id 
                                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                                BETWEEN '$period[0]-10' AND '$period[0]-12'
                                        LEFT JOIN mst_training_approval AS mta
                                            ON mta.training_id = mtl.training_id 
                                    where mmugg.grade_group_id BETWEEN 1 AND 5
                                    AND mmu.deleted_at IS NULL
                                    AND mta.training_status = 'approve'
                                    GROUP BY mtl.training_id
                                ) AS q3
                            )AS q3
                            CROSS JOIN (
                                SELECT
                                    (
                                        SELECT
                                            count(mmu.user_nik) AS total_karyawan
                                        FROM  mst_main_user AS mmu
                                            LEFT JOIN mst_main_user_grade AS mmug
                                                ON mmug.grade_id = mmu.grade_id
                                            LEFT JOIN mst_main_user_grade_group AS mmugg
                                                ON mmugg.grade_group_id = mmug.grade_group_id
                                        WHERE 1=1
                                        AND mmugg.grade_group_id BETWEEN 1 AND 5
                                        AND DATE_FORMAT(mmu.user_join_date, '%Y-%m') <= '$period[1]-03'
                                        AND mmu.deleted_at IS NULL
                                    ) AS total_karyawan_q4,
                                    sum(total_participant) AS total_participant_q4,
                                    sum(total_hari) AS total_hari_q4,
                                    (sum(total_participant) * sum(total_hari)) AS total_mandays_q4
                                FROM (
                                    SELECT
                                        count(mtlp.training_user_nik) total_participant,
                                        mtl.training_total AS total_hari
                                    FROM mst_main_user AS mmu
                                        LEFT JOIN mst_main_user_grade AS mmug
                                            ON mmug.grade_id = mmu.grade_id 
                                        LEFT JOIN mst_main_user_grade_group AS mmugg
                                            ON mmugg.grade_group_id = mmug.grade_group_id
                                        LEFT JOIN mst_training_list_participant AS mtlp
                                            ON mtlp.training_user_nik = mmu.user_nik
                                        LEFT JOIN mst_training_list AS mtl
                                            ON mtl.training_id = mtlp.training_id 
                                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                                BETWEEN '$period[1]-01' AND '$period[1]-03'
                                        LEFT JOIN mst_training_approval AS mta
                                            ON mta.training_id = mtl.training_id 
                                    where mmugg.grade_group_id BETWEEN 1 AND 5
                                    AND mmu.deleted_at IS NULL
                                    AND mta.training_status = 'approve'
                                    GROUP BY mtl.training_id
                                ) AS q4
                            )AS q4
                        ) AS manager
                    UNION
                    SELECT 
                        *
                    FROM (
                        SELECT
                            'Manager' AS grade,
                            COALESCE(q1.total_karyawan_q1,0) AS total_karyawan_q1,
                            COALESCE(q1.total_participant_q1,0) AS total_participant_q1,
                            COALESCE(q1.total_hari_q1,0) AS total_hari_q1,
                            COALESCE(q1.total_mandays_q1,0) AS total_mandays_q1,
                            COALESCE(q2.total_karyawan_q2,0) AS total_karyawan_q2,
                            COALESCE(q2.total_participant_q2,0) AS total_participant_q2,
                            COALESCE(q2.total_hari_q2,0) AS total_hari_q2,
                            COALESCE(q2.total_mandays_q2,0) AS total_mandays_q2,
                            COALESCE(q3.total_karyawan_q3,0) AS total_karyawan_q3,
                            COALESCE(q3.total_participant_q3,0) AS total_participant_q3,
                            COALESCE(q3.total_hari_q3,0) AS total_hari_q3,
                            COALESCE(q3.total_mandays_q3,0) AS total_mandays_q3,
                            COALESCE(q4.total_karyawan_q4,0) AS total_karyawan_q4,
                            COALESCE(q4.total_participant_q4,0) AS total_participant_q4,
                            COALESCE(q4.total_hari_q4,0) AS total_hari_q4,
                            COALESCE(q4.total_mandays_q4,0) AS total_mandays_q4
                        FROM 
                            (
                                SELECT
                                    (
                                        SELECT
                                            count(mmu.user_nik) AS total_karyawan
                                        FROM  mst_main_user AS mmu
                                            LEFT JOIN mst_main_user_grade AS mmug
                                                ON mmug.grade_id = mmu.grade_id
                                            LEFT JOIN mst_main_user_grade_group AS mmugg
                                                ON mmugg.grade_group_id = mmug.grade_group_id
                                        WHERE 1=1
                                        AND mmugg.grade_group_id BETWEEN 6 AND 7
                                        AND DATE_FORMAT(mmu.user_join_date, '%Y-%m') <= '$period[0]-06'
                                        AND mmu.deleted_at IS NULL
                                    ) AS total_karyawan_q1,
                                    sum(total_participant) AS total_participant_q1,
                                    sum(total_hari) AS total_hari_q1,
                                    (sum(total_participant) * sum(total_hari)) AS total_mandays_q1
                                FROM (
                                    SELECT
                                        count(mtlp.training_user_nik) total_participant,
                                        mtl.training_total AS total_hari
                                    FROM mst_main_user AS mmu
                                        LEFT JOIN mst_main_user_grade AS mmug
                                            ON mmug.grade_id = mmu.grade_id 
                                        LEFT JOIN mst_main_user_grade_group AS mmugg
                                            ON mmugg.grade_group_id = mmug.grade_group_id
                                        LEFT JOIN mst_training_list_participant AS mtlp
                                            ON mtlp.training_user_nik = mmu.user_nik
                                        LEFT JOIN mst_training_list AS mtl
                                            ON mtl.training_id = mtlp.training_id 
                                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                                BETWEEN '$period[0]-04' AND '$period[0]-06'
                                        LEFT JOIN mst_training_approval AS mta
                                            ON mta.training_id = mtl.training_id 
                                    where mmugg.grade_group_id BETWEEN 6 AND 7
                                    AND mmu.deleted_at IS NULL
                                    AND mta.training_status = 'approve'
                                    GROUP BY mtl.training_id
                                ) AS q1
                            )AS q1
                            CROSS JOIN (
                                SELECT
                                    (
                                        SELECT
                                            count(mmu.user_nik) AS total_karyawan
                                        FROM  mst_main_user AS mmu
                                            LEFT JOIN mst_main_user_grade AS mmug
                                                ON mmug.grade_id = mmu.grade_id
                                            LEFT JOIN mst_main_user_grade_group AS mmugg
                                                ON mmugg.grade_group_id = mmug.grade_group_id
                                        WHERE 1=1
                                        AND mmugg.grade_group_id BETWEEN 6 AND 7
                                        AND DATE_FORMAT(mmu.user_join_date, '%Y-%m') <= '$period[0]-09'
                                        AND mmu.deleted_at IS NULL
                                    ) AS total_karyawan_q2,
                                    sum(total_participant) AS total_participant_q2,
                                    sum(total_hari) AS total_hari_q2,
                                    (sum(total_participant) * sum(total_hari)) AS total_mandays_q2
                                FROM (
                                    SELECT
                                        count(mtlp.training_user_nik) total_participant,
                                        mtl.training_total AS total_hari
                                    FROM mst_main_user AS mmu
                                        LEFT JOIN mst_main_user_grade AS mmug
                                            ON mmug.grade_id = mmu.grade_id 
                                        LEFT JOIN mst_main_user_grade_group AS mmugg
                                            ON mmugg.grade_group_id = mmug.grade_group_id
                                        LEFT JOIN mst_training_list_participant AS mtlp
                                            ON mtlp.training_user_nik = mmu.user_nik
                                        LEFT JOIN mst_training_list AS mtl
                                            ON mtl.training_id = mtlp.training_id 
                                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                                BETWEEN '$period[0]-07' AND '$period[0]-09'
                                        LEFT JOIN mst_training_approval AS mta
                                            ON mta.training_id = mtl.training_id 
                                    where mmugg.grade_group_id BETWEEN 6 AND 7
                                    AND mmu.deleted_at IS NULL
                                    AND mta.training_status = 'approve'
                                    GROUP BY mtl.training_id
                                ) AS q2
                            )AS q2
                            CROSS JOIN (
                                SELECT
                                    (
                                        SELECT
                                            count(mmu.user_nik) AS total_karyawan
                                        FROM  mst_main_user AS mmu
                                            LEFT JOIN mst_main_user_grade AS mmug
                                                ON mmug.grade_id = mmu.grade_id
                                            LEFT JOIN mst_main_user_grade_group AS mmugg
                                                ON mmugg.grade_group_id = mmug.grade_group_id
                                        WHERE 1=1
                                        AND mmugg.grade_group_id BETWEEN 6 AND 7
                                        AND DATE_FORMAT(mmu.user_join_date, '%Y-%m') <= '$period[0]-12'
                                        AND mmu.deleted_at IS NULL
                                    ) AS total_karyawan_q3,
                                    sum(total_participant) AS total_participant_q3,
                                    sum(total_hari) AS total_hari_q3,
                                    (sum(total_participant) * sum(total_hari)) AS total_mandays_q3
                                FROM (
                                    SELECT
                                        count(mtlp.training_user_nik) total_participant,
                                        mtl.training_total AS total_hari
                                    FROM mst_main_user AS mmu
                                        LEFT JOIN mst_main_user_grade AS mmug
                                            ON mmug.grade_id = mmu.grade_id 
                                        LEFT JOIN mst_main_user_grade_group AS mmugg
                                            ON mmugg.grade_group_id = mmug.grade_group_id
                                        LEFT JOIN mst_training_list_participant AS mtlp
                                            ON mtlp.training_user_nik = mmu.user_nik
                                        LEFT JOIN mst_training_list AS mtl
                                            ON mtl.training_id = mtlp.training_id 
                                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                                BETWEEN '$period[0]-10' AND '$period[0]-12'
                                        LEFT JOIN mst_training_approval AS mta
                                            ON mta.training_id = mtl.training_id 
                                    where mmugg.grade_group_id BETWEEN 6 AND 7
                                    AND mmu.deleted_at IS NULL
                                    AND mta.training_status = 'approve'
                                    GROUP BY mtl.training_id
                                ) AS q3
                            )AS q3
                            CROSS JOIN (
                                SELECT
                                    (
                                        SELECT
                                            count(mmu.user_nik) AS total_karyawan
                                        FROM  mst_main_user AS mmu
                                            LEFT JOIN mst_main_user_grade AS mmug
                                                ON mmug.grade_id = mmu.grade_id
                                            LEFT JOIN mst_main_user_grade_group AS mmugg
                                                ON mmugg.grade_group_id = mmug.grade_group_id
                                        WHERE 1=1
                                        AND mmugg.grade_group_id BETWEEN 6 AND 7
                                        AND DATE_FORMAT(mmu.user_join_date, '%Y-%m') <= '$period[1]-03'
                                        AND mmu.deleted_at IS NULL
                                    ) AS total_karyawan_q4,
                                    sum(total_participant) AS total_participant_q4,
                                    sum(total_hari) AS total_hari_q4,
                                    (sum(total_participant) * sum(total_hari)) AS total_mandays_q4
                                FROM (
                                    SELECT
                                        count(mtlp.training_user_nik) total_participant,
                                        mtl.training_total AS total_hari
                                    FROM mst_main_user AS mmu
                                        LEFT JOIN mst_main_user_grade AS mmug
                                            ON mmug.grade_id = mmu.grade_id 
                                        LEFT JOIN mst_main_user_grade_group AS mmugg
                                            ON mmugg.grade_group_id = mmug.grade_group_id
                                        LEFT JOIN mst_training_list_participant AS mtlp
                                            ON mtlp.training_user_nik = mmu.user_nik
                                        LEFT JOIN mst_training_list AS mtl
                                            ON mtl.training_id = mtlp.training_id 
                                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                                BETWEEN '$period[1]-01' AND '$period[1]-03'
                                        LEFT JOIN mst_training_approval AS mta
                                            ON mta.training_id = mtl.training_id 
                                    where mmugg.grade_group_id BETWEEN 6 AND 7
                                    AND mmu.deleted_at IS NULL
                                    AND mta.training_status = 'approve'
                                    GROUP BY mtl.training_id
                                ) AS q4
                            )AS q4
                        ) AS manager";
        return DB::select($query);
    }

    public function ReportExpanse($request)
    {
        $period = explode('-',$request->period_name);
        /**
         * [0] untuk q1 - q3
         * [1] untuk q4
         */

        $query = "  SELECT
                        mmd.department_name,
                        IFNULL(SUM(q1.total_fee),0) AS total_fee_q1,
                        IFNULL(SUM(q2.total_fee),0) AS total_fee_q2,
                        IFNULL(SUM(q3.total_fee),0) AS total_fee_q3,
                        IFNULL(SUM(q4.total_fee),0) AS total_fee_q4
                    FROM mst_main_department AS mmd
                        LEFT JOIN
                        (
                            SELECT 
                                mmu.department_id,
                                count(mtlp.training_user_nik) AS total_participant,
                                ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                            FROM mst_training_list AS mtl
                                LEFT JOIN mst_training_list_participant AS mtlp
                                    ON mtlp.training_id = mtl.training_id 
                                LEFT JOIN mst_training_approval AS mta
                                    ON mta.training_id = mtl.training_id
                                LEFT JOIN mst_main_user AS mmu
                                    ON mmu.user_nik = mtlp.training_user_nik
                            WHERE mta.training_status = 'approve'
                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                BETWEEN '$period[0]-04' AND '$period[0]-06'
                            GROUP BY
                                mmu.department_id,
                                mtl.training_id
                        )AS q1
                            ON q1.department_id = mmd.department_id
                        LEFT JOIN 
                        (
                            SELECT 
                                mmu.department_id,
                                count(mtlp.training_user_nik) AS total_participant,
                                ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                            FROM mst_training_list AS mtl
                                LEFT JOIN mst_training_list_participant AS mtlp
                                    ON mtlp.training_id = mtl.training_id 
                                LEFT JOIN mst_training_approval AS mta
                                    ON mta.training_id = mtl.training_id
                                LEFT JOIN mst_main_user AS mmu
                                    ON mmu.user_nik = mtlp.training_user_nik
                            WHERE mta.training_status = 'approve'
                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                BETWEEN '$period[0]-07' AND '$period[0]-09'
                            GROUP BY
                                mmu.department_id,
                                mtl.training_id 
                        )AS q2
                            ON q2.department_id = mmd.department_id
                        LEFT JOIN 
                        (
                            SELECT 
                                mmu.department_id,
                                count(mtlp.training_user_nik) AS total_participant,
                                ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                            FROM mst_training_list AS mtl
                                LEFT JOIN mst_training_list_participant AS mtlp
                                    ON mtlp.training_id = mtl.training_id 
                                LEFT JOIN mst_training_approval AS mta
                                    ON mta.training_id = mtl.training_id
                                LEFT JOIN mst_main_user AS mmu
                                    ON mmu.user_nik = mtlp.training_user_nik
                            WHERE mta.training_status = 'approve'
                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                BETWEEN '$period[0]-10' AND '$period[0]-12'
                            GROUP BY
                                mmu.department_id,
                                mtl.training_id 
                        )AS q3
                            ON q3.department_id = mmd.department_id
                        LEFT JOIN 
                        (
                            SELECT 
                                mmu.department_id,
                                count(mtlp.training_user_nik) AS total_participant,
                                ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                            FROM mst_training_list AS mtl
                                LEFT JOIN mst_training_list_participant AS mtlp
                                    ON mtlp.training_id = mtl.training_id 
                                LEFT JOIN mst_training_approval AS mta
                                    ON mta.training_id = mtl.training_id
                                LEFT JOIN mst_main_user AS mmu
                                    ON mmu.user_nik = mtlp.training_user_nik
                            WHERE mta.training_status = 'approve'
                            AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                BETWEEN '$period[1]-01' AND '$period[1]-03'
                            GROUP BY
                                mmu.department_id,
                                mtl.training_id 
                        )AS q4
                            ON q4.department_id = mmd.department_id
                    GROUP BY
                        mmd.department_id,
                        mmd.department_name ";

        return DB::select($query);
    }

    public function ReportFeedback($request)
    {
        $queryCondition = $this->queryCondition($request);
        $query = "  SELECT
                        MONTH(mtl.training_date_request) AS bulan,
                        YEAR(mtl.training_date_request) AS tahun,
                        mtl.training_topic,
                        mtv.vendor_type,
                        mtv.vendor_name,
                        mtc.category_name,
                        mtl.training_total,
                        mmd.department_name,
                        mtlp.training_user_nik,
                        mmu.user_name,
                        mtm.method_name,
                        mtf.*
                    FROM mst_training_list_participant AS mtlp 
                        LEFT JOIN mst_training_list AS mtl
                            ON mtl.training_id = mtlp.training_id
                        LEFT JOIN mst_training_approval AS mta
                            ON mta.training_id = mtl.training_id
                        LEFT JOIN mst_main_user AS mmu 
                            ON mmu.user_nik = mtlp.training_user_nik
                        LEFT JOIN mst_training_vendor AS mtv
                            ON mtv.vendor_id = mtl.vendor_id
                        LEFT JOIN mst_training_category AS mtc
                            ON mtc.category_id = mtl.category_id 
                        LEFT JOIN mst_main_department AS mmd
                            ON mmd.department_id = mmu.department_id
                        LEFT JOIN mst_training_feedback AS mtf
                            ON mtf.training_participant_id = mtlp.training_participant_id
                        LEFT JOIN mst_training_method AS mtm
                            ON mtm.method_id = mtl.method_id
                    where 1=1
                        AND mta.training_status = 'approve'
                        $queryCondition
                    ORDER BY 
                        MONTH(mtl.training_date_request),
                        mtl.training_topic,
                        mmd.department_name,
                        mtlp.training_user_nik";

        return DB::select($query);
    }

    public function ReportExpanseLevel($request)
    {
        $period = explode('-',$request->period_name);
        /**
         * [0] untuk q1 - q3
         * [1] untuk q4
         */

        $query = "  SELECT
                        'Workman - Staf' AS level,
                        IFNULL(sum(ws.total_fee_q1),0) AS total_fee_q1,
                        IFNULL(sum(ws.total_fee_q2),0) AS total_fee_q2,
                        IFNULL(sum(ws.total_fee_q3),0) AS total_fee_q3,
                        IFNULL(sum(ws.total_fee_q4),0) AS total_fee_q4
                    FROM 
                    (
                        SELECT 
                            IFNULL(sum(q1.total_fee),0) AS total_fee_q1,
                            IFNULL(sum(q2.total_fee),0) AS total_fee_q2,
                            IFNULL(sum(q3.total_fee),0) AS total_fee_q3,
                            IFNULL(sum(q4.total_fee),0) AS total_fee_q4
                        FROM mst_main_user_grade_group AS mmugg
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 1 AND 3
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[0]-04' AND '$period[0]-06'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            )AS q1
                                ON q1.grade_group_id = mmugg.grade_group_id 
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 1 AND 3
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[0]-07' AND '$period[0]-09'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            ) AS q2
                                ON q2.grade_group_id = mmugg.grade_group_id 
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 1 AND 3
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[0]-10' AND '$period[0]-12'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            )AS q3
                                ON q3.grade_group_id = mmugg.grade_group_id 
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 1 AND 3
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[1]-01' AND '$period[1]-03'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            )AS q4
                                ON q4.grade_group_id = mmugg.grade_group_id 
                        GROUP BY mmugg.grade_group_id
                    ) AS ws
                    UNION
                    SELECT
                        'Supervisor - Executife' AS level,
                        IFNULL(sum(se.total_fee_q1),0) AS total_fee_q1,
                        IFNULL(sum(se.total_fee_q2),0) AS total_fee_q2,
                        IFNULL(sum(se.total_fee_q3),0) AS total_fee_q3,
                        IFNULL(sum(se.total_fee_q4),0) AS total_fee_q4
                    FROM 
                    (
                        SELECT 
                            IFNULL(sum(q1.total_fee),0) AS total_fee_q1,
                            IFNULL(sum(q2.total_fee),0) AS total_fee_q2,
                            IFNULL(sum(q3.total_fee),0) AS total_fee_q3,
                            IFNULL(sum(q4.total_fee),0) AS total_fee_q4
                        FROM mst_main_user_grade_group AS mmugg
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 4 AND 5
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[0]-04' AND '$period[0]-06'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            )AS q1
                                ON q1.grade_group_id = mmugg.grade_group_id 
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 4 AND 5
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[0]-07' AND '$period[0]-09'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            ) AS q2
                                ON q2.grade_group_id = mmugg.grade_group_id 
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 4 AND 5
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[0]-10' AND '$period[0]-12'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            )AS q3
                                ON q3.grade_group_id = mmugg.grade_group_id 
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 4 AND 5
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[1]-01' AND '$period[1]-03'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            )AS q4
                                ON q4.grade_group_id = mmugg.grade_group_id 
                        GROUP BY mmugg.grade_group_id
                    ) AS se
                    UNION
                    SELECT
                        'Manager - Senior Manager' AS level,
                        IFNULL(sum(ms.total_fee_q1),0) AS total_fee_q1,
                        IFNULL(sum(ms.total_fee_q2),0) AS total_fee_q2,
                        IFNULL(sum(ms.total_fee_q3),0) AS total_fee_q3,
                        IFNULL(sum(ms.total_fee_q4),0) AS total_fee_q4
                    FROM 
                    (
                        SELECT 
                            IFNULL(sum(q1.total_fee),0) AS total_fee_q1,
                            IFNULL(sum(q2.total_fee),0) AS total_fee_q2,
                            IFNULL(sum(q3.total_fee),0) AS total_fee_q3,
                            IFNULL(sum(q4.total_fee),0) AS total_fee_q4
                        FROM mst_main_user_grade_group AS mmugg
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 6 AND 7
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[0]-04' AND '$period[0]-06'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            )AS q1
                                ON q1.grade_group_id = mmugg.grade_group_id 
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 6 AND 7
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[0]-07' AND '$period[0]-09'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            ) AS q2
                                ON q2.grade_group_id = mmugg.grade_group_id 
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 6 AND 7
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[0]-10' AND '$period[0]-12'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            )AS q3
                                ON q3.grade_group_id = mmugg.grade_group_id 
                            LEFT JOIN 
                            (
                                SELECT 
                                    mmug.grade_group_id,
                                    ((mtl.training_fee / mtl.training_participants) * count(mtlp.training_user_nik) ) AS total_fee
                                FROM mst_training_list AS mtl
                                    LEFT JOIN mst_training_list_participant AS mtlp
                                        ON mtlp.training_id = mtl.training_id 
                                    LEFT JOIN mst_training_approval AS mta
                                        ON mta.training_id = mtl.training_id
                                    LEFT JOIN mst_main_user AS mmu
                                        ON mmu.user_nik = mtlp.training_user_nik
                                    LEFT JOIN mst_main_user_grade AS mmug
                                        ON mmug.grade_id = mmu.grade_id 
                                    LEFT JOIN mst_main_user_grade_group AS mmugg
                                        ON mmugg.grade_group_id = mmug.grade_group_id 
                                WHERE mta.training_status = 'approve'
                                AND mmugg.grade_group_id BETWEEN 6 AND 7
                                AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                    BETWEEN '$period[1]-01' AND '$period[1]-03'
                                GROUP BY
                                    mtl.training_id,
                                    mmug.grade_group_id
                            )AS q4
                                ON q4.grade_group_id = mmugg.grade_group_id 
                        GROUP BY mmugg.grade_group_id
                    ) AS ms";
        
        return DB::select($query);
    }

    public functiON queryCondition($request)
    {
        $queryCondition = '';
        if($request->type == 'period'):
            $period = explode('-',$request->period_name); // memecah period_name karena formatnya e.g 2020 - 2021
            $queryCondition = "AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')
                                BETWEEN '$period[0]-04' AND '$period[1]-03'";
        elseif ($request->type == 'month') :
            $month_number = date('m', strtotime($request->month_name));
            $queryCondition = "AND MONTH(mtl.training_date_request) = '$month_number'
                                AND YEAR(mtl.training_date_request) = '$request->year_name'";
        elseif ($request->type == 'quarter'):
            $period = explode('-',$request->period_name); // memecah period_name karena formatnya e.g 2020 - 2021
            $queryCondition = "AND DATE_FORMAT(mtl.training_date_request, '%Y-%m')";
            if ($request->quarter_name == 'Q1') : 
                $queryCondition .= "BETWEEN '$period[0]-04' AND '$period[0]-06'";
            elseif ($request->quarter_name == 'Q2'):
                $queryCondition .= "BETWEEN '$period[0]-07' AND '$period[0]-09'";
            elseif ($request->quarter_name == 'Q3'):
                $queryCondition .= "BETWEEN '$period[0]-09' AND '$period[0]-12'";
            elseif ($request->quarter_name == 'Q4'):
                $queryCondition .= "BETWEEN '$period[1]-01' AND '$period[1]-03'";
            endif;
        endif;

        return $queryCondition;
    }
}