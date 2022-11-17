<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use App\Http\Response\StatusCode;

class ApiKeyAuth
{
    const AUTH_HEADER = 'Authorization';
    
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header(self::AUTH_HEADER);
        $apiKey = ApiKey::getApiKey($header);

        if ($apiKey instanceof ApiKey) {
            return $next($request);
        }

        return response([
            'errors' => [[
                'message' => 'Unauthorized'
            ]]
        ], StatusCode::UNAUTHORIZED);
    }

}