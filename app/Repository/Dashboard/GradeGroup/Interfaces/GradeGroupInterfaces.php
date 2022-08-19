<?php

namespace App\Repository\Dashboard\GradeGroup\Interfaces;

interface GradeGroupInterfaces
{
    public function getAllGradeGroup();
    
    public function getGradeGroupById($id);

    public function updateGradeGroup($request);

    public function deleteGradeGroup($request);

    public function insertGradeGroup($request);

}