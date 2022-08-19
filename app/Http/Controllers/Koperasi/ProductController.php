<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Koperasi\ProductService;
use App\Http\Requests\Koperasi\ProductRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ProductController extends Controller
{
    private $ProductService;

    public function __construct(ProductService $ProductService)
    {
        $this->ProductService = $ProductService;
    }
    
    public function index(Request $request)
    {
        $product = $this->ProductService->getProduct($request);
        $category = $this->ProductService->getCategoryProduct($request);
        $brand = $this->ProductService->getBrandProduct();
        return view('koperasi.product',compact('product','category','brand'));
    }

    public function edit($id)
    {
        $data = $this->ProductService->getDetailProduct($id);
        return \Response::success($data);
    }

    public function store(ProductRequest $request)
    {
        $this->ProductService->addCart($request);
        return \Response::success(["message"=>"Item Has Been Added To Cart"]);
    }

    public function update(ProductRequest $request)
    {
        $this->ProductService->updateQty($request);
        return \Response::success(["message"=>"Qty Update"]);
    }

    public function destroy(Request $request)
    {
        $this->ProductService->deleteCart($request);
        return \Response::success(["message"=>"Item Delete From Cart"]);
    }

    public function CountCart()
    {
        $data = $this->ProductService->CountCart();
        return \Response::success($data);
    }

    public function detailCart()
    {
        $data = $this->ProductService->detailCartUser();
        return \Response::success($data);
    }

    public static function checkImage($url)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', $url);
            return true;
        }
        catch (RequestException  $e) {
            return false;
        }
    }
}
