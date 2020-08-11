<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\APIHelpers;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        try {
            if (JWTAuth::parseToken()->authenticate()) {
                return $next($request);
            }
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $error = [
                    'msg' => 'Token Invalid Exception!',
                    'code' => 401
                ];
                return APIHelpers::createAPIResponse(false, 401, $error['msg'], null, $error);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $error = [
                    'msg' => 'Token Expired Exception!',
                    'code' => 401
                ];
                return APIHelpers::createAPIResponse(false, 401, $error['msg'], null, $error);
            } else if ( $e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
                $error = [
                    'msg' => 'JWT Exception!',
                    'code' => 401
                ];
                return APIHelpers::createAPIResponse(false, 401, $error['msg'], null, $error);
            } else {
                $error = [
                    'msg' => 'Auth Failed!',
                    'code' => 401
                ];
                return APIHelpers::createAPIResponse(false, 401, $error['msg'], null, $error);
            }
        }
    }
}
