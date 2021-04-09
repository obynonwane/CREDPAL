<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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

            //    $request->headers->add(["Authorization"=>"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hbnNjaW1zLnRlc3RcL2FwaVwvdjFcL0NvbW1vblwvYXV0aCIsImlhdCI6MTU4OTYxMjA0NCwiZXhwIjoxNTg5Nzg0ODQ0LCJuYmYiOjE1ODk2MTIwNDQsImp0aSI6InVwT2pGMjRkNjhncDlBNDYiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.knytWTlZC1WVo1PVQ1M5n0pBQkyGQqyr_i62LB1z688"]);

            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token is Invalid',
                ], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {

                return response()->json([
                    'status' => false,
                    'message' => 'Token is Expired',
                ], 401);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Authorization Token not found',
                    'error' => $e->getMessage(),
                ], 401);
            }
        }
        return $next($request);
    }
}
