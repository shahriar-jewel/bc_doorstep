<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiToken;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
// Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

class CheckApiAuth
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
        if($request->has('userid') || $request->has('token') )
        {
            $tokenInfo = ApiToken::where( 'token',$request->input('token'))
            ->where( 'userid',$request->input('userid'))
            ->first();
            if (count($tokenInfo) > 0 ) {
                return $next($request);
            }
            else
            {
                $statusCode = 401;
                $status = 'failed' ;
                $msg = 'Session expired. Please logout and log in again.' ;
                $data = [
                    'error_code'    => $statusCode,
                    'error_msg'     => "Api token mismatched!"
                ];
                $objName = "error";
                $outputJson = [
                    'status'    => $status ,
                    'message'   => $msg ,
                    $objName    => $data ,
                ];
                return response($outputJson,200);
            }
        }
        else
        {
            $statusCode = 401;
            $status = 'failed' ;
            $msg = 'Unauthorized Action!' ;
            $data = [
                'error_code'    => $statusCode,
                'error_msg'     => "Unauthorized action"
            ];
            $objName = "error";
            $outputJson = [
                'status'    => $status ,
                'message'   => $msg ,
                $objName    => $data ,
            ];
            return response($outputJson,200);
            // return redirect('/api/wrongresponse');
        }
        
    }
}
