<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Captcha;

class ChaptchaController extends Controller
{
    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
