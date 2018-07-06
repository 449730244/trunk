<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\InvalidRequestException;
use Auth;

class CheckLogin
{

    public function handle($request, Closure $next)
    {
       if (!Auth::check()){
           throw new InvalidRequestException('请先登录', 1000,'401');
       }

       return $next($request);
    }

}
