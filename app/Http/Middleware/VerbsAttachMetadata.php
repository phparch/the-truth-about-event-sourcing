<?php

namespace App\Http\Middleware;

use Carbon\CarbonImmutable;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Thunk\Verbs\Facades\Verbs;

class VerbsAttachMetadata
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Verbs::createMetadataUsing(fn() => [
            'when' => CarbonImmutable::now(),
            'user' => auth()->user(),
            'request' => $request,
            'server' => $request->server(),
            /*
            'server' => [
                'IP' => $request->server('REMOTE_ADDR'),
                'PATH' => $request->server('PATH_INFO'),
                'METHOD' => $request->server('REQUEST_METHOD'),
                'REFERER' => $request->server('HTTP_REFERER'),
            ]
             */
        ]);
        return $next($request);
    }
}
