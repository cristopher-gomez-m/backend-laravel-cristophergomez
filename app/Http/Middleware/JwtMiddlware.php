<?php
namespace App\Http\Middleware;
use Closure;
//use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Utils\ApiResponse;
class JwtMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $payload = JWTAuth::parseToken()->getPayload();
            $request->request->add(['usuario_id' => $payload->get('sub')]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                $apiResponse = new ApiResponse([]);
                $apiResponse->message = 'Token is Invalid';
                $apiResponse->statusCode = 401;
                return Response()->json($apiResponse, $apiResponse->statusCode);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                $apiResponse = new ApiResponse([]);
                $apiResponse->message = 'Token is Expired';
                $apiResponse->statusCode = 401;
                return Response()->json($apiResponse, $apiResponse->statusCode);
            } else {
                $apiResponse = new ApiResponse([]);
                $apiResponse->message = 'Authorization Token not found';
                $apiResponse->statusCode = 401;
                return Response()->json($apiResponse, $apiResponse->statusCode);
            }
        }
        return $next($request);
    }
}