<?php 

namespace App\Repository\Dashboard\ApprovalMatrix\Interfaces;

interface ApprovalMatrixInterfaces
{
    public function getAllUserApproval();

    public function getDetailApprovalById($id);

    public function updateApprovalUser($request);
    
    public function deleteApprovalUser($request);

    public function insertApprovalUser($request);

    public function getApprovalByNik($nik);
}