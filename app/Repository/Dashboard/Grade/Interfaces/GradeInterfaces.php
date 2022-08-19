<?php

namespace App\Repository\Dashboard\Grade\Interfaces;

interface GradeInterfaces
{
    public function getAllGrade();

    public function getGradeById($id);

    public function updateGrade($request);

    public function deleteGrade($request);

    public function insertGrade($request);

    public function getDataByName($nama);
}