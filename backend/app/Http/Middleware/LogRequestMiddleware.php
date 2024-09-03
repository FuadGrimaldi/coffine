<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        // Format log request
        Log::info(sprintf(
            "%s %s %s - %s (%s ms)",
            $request->method(),
            $request->fullUrl(),
            $response->getStatusCode(),
            $request->ip(),
            number_format($duration * 1000, 2)
        ));

        return $response;
    }
}
