<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Training\VendorService;
use App\Http\Requests\Training\VendorRequest;

class VendorController extends Controller
{

    private $VendorService;

    /**
     * __construct
     *
     * Defined VendorService
     * @return void
     */
    public function __construct(VendorService $VendorService)
    {
        $this->VendorService = $VendorService;
    }
    
    public function show()
    {
        return $this->VendorService->show();
    }

    public function create(VendorRequest $request)
    {
        $this->VendorService->create($request);
        return \Response::success(["message"=>"Vendor Add"]);
    }

    public function detail($id)
    {
        $data = $this->VendorService->detail($id);
        return response()->json(["status" => "success", "data" => $data]);
    }

    public function update(VendorRequest $request)
    {
        $this->VendorService->update($request);
        return \Response::success(["message"=>"Vendor Updated"]);
    }

    public function destroy(VendorRequest $request)
    {
        $this->VendorService->destroy($request);
        return \Response::success(["message"=>"Vendor deleted"]);
    }

    public function vendorByType(Request $request)
    {
        $data = $this->VendorService->getVendorByType($request);
        return response()->json(["status" => "success", "data" => $data]);
    }

    public function upload(Request $request)
    {
        $data = $this->VendorService->upload($request);
        return \Response::success([
            "message"=>"Upload Success",
            "data"=>$data,
        ]);
    }

    public function download()
    {
        return $this->VendorService->downloadVendor();
    }

    public function downloadById($id)
    {
        return $this->VendorService->downloadVendorById($id);
    }
}
