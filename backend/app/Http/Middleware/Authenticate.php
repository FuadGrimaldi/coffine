<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Log::info('Request method: ' . $request->method());
        // Log::info('Request URL: ' . $request->url());
        // Log::info('Request headers: ' . json_encode($request->headers->all()));
        return $request->expectsJson() ? null : route('login');
    }
}
