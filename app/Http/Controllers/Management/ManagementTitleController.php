<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TitleRequest;
use App\Services\Dashboard\TitleService;

class ManagementTitleController extends Controller
{
    private $TitleService;

    public function __construct(TitleService $TitleService)
    {
        $this->TitleService = $TitleService;
    }

    public function index()
    {
        return view('management/title');
    }

    public function AllTitle()
    {
        return $this->TitleService->getAllTitle();
    }

    public function getTitleById($id)
    {
        $data = $this->TitleService->getTitleById($id);
        return response()->json(["statu"=>"success","data"=>$data]);
    }

    public function updateTitle(TitleRequest $request)
    {
        $this->TitleService->updateTitle($request);
        return response()->json(["status"=>"success","message"=>"Title Updated"]);
    }

    public function deleteTitle(Request $request)
    {   
        $this->TitleService->deleteTitle($request);
        return response()->json(["status"=>"success","message"=>"Title Deleted"]);
    }

    public function insertTitle(TitleRequest $request){
        $this->TitleService->insertTitle($request);
        return response()->json(["status"=>"success","message"=>"Title Added"]);
    }
}
