<?php

namespace App\Helper;

class Response
{
    public function __construct()
    {
        
    }

    public static function success($data)
    {
        return response()->json([
            "status" => 200,
            "message" => "success",
            "data" => $data
        ]);
    }
}