<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Type;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TypeRequest;
use Illuminate\Support\Facades\DB;
use App\Services\Dashboard\TypeService;
class ManagementTypeController extends Controller
{
    private $TypeService;

    public function __construct(TypeService $TypeService)
    {
        $this->TypeService = $TypeService;
    }

    public function index()
    {
        return view('management/type');
    }

    public function AllType()
    {
        return $this->TypeService->getAllType();
    }

    public function getTypeById($id)
    {
        $data = $this->TypeService->getTypeById($id);
        return response()->json(["statu" => "success", "data" => $data]);
    }

    public function updateType(TypeRequest $request)
    {
        $this->TypeService->updateType($request);
        return response()->json(["status" => "success", "message" => "Title Updated"]);
    }

    public function deleteType(Request $request)
    {
        $this->TypeService->deleteType($request);
        return response()->json(["status" => "success", "message" => "Type Deleted"]);
    }

    public function insertType(TypeRequest $request)
    {
        $this->TypeService->insertType($request);
        return response()->json(["status" => "success", "message" => "Type Added"]);
    }
}
