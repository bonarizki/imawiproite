<?php

namespace App\Http\Controllers\RegisterVendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;

class AccessController extends Controller
{
    public $UserInterfaces; 

    public function __construct(UserInterfaces $UserInterfaces)
    {
        $this->UserInterfaces = $UserInterfaces;
    }

    public function index()
    {
        $data = $this->UserInterfaces->AccessRegven();
        return response()->json($data);
    }
}
