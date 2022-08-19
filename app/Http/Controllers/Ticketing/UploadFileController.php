<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\UploadFileService;


class UploadFileController extends Controller
{
    public $UploadFileService;

    public function __construct(UploadFileService $UploadFileService)
    {
        $this->UploadFileService = $UploadFileService;
    }

    public function upload(Request $request)
    {
        $this->UploadFileService->handle($request);
        return \Response::success(["message"=>"File Uploaded"]);
    }
}
