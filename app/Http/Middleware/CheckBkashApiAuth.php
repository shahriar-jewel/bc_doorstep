<?php

namespace App\Http\Middleware;

use Closure;

class CheckBkashApiAuth
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
        if(session()->has('bkash_customerid'))
        {
            return $next($request);
        }
        else
        {
            $data = [
                'errorMessage'  => "Session expired. Please login again."
            ];
            
            $result = json_encode($data);

            return response($result,200);
        }
    }
}
