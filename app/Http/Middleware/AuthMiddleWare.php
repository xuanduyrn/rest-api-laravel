<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\APIHelpers;

class AuthMiddleWare
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
        if ((int)$request -> all()['id'] === 12) { // TODO: Backend handle login auth middleware => Mai lam
            return $next($request);
        } else {
            $error = [
                'msg' => 'Auth request failed!',
                'code' => 401
            ];
            return APIHelpers::createAPIResponse(false, 401, $error['msg'], null, $error);
        }
    }
}
