<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Exceptions\InvalidRequestException;

class CheckIsCustomerService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->CustomerService()->where('is_on',1)->first()){
            throw new InvalidRequestException('你不是客服无法访问', 2000,'401');
        }
        return $next($request);
    }
}
