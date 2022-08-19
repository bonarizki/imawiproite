<?php

namespace App\Http\Middleware;

use Closure;

class ValidateToken
{
    private $Token;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        //1niT0k3nKu
        $this->Token = '8042963dd82b993036afa47b0a6c5cb3';
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('token');
        if ($token != $this->Token) {
            return response()->json(["message"=>"wrong tokeno"],401);
        }
        return $next($request);
    }
}
