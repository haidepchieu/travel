<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET requests to public pages (exclude admin, livewire, assets)
        if ($request->isMethod('GET') &&
            $response->getStatusCode() === 200 &&
            !$request->is('admin*') &&
            !$request->is('livewire*') &&
            !$request->is('storage*') &&
            !$request->is('up') &&
            !$request->ajax()) {

            try {
                PageView::create([
                    'ip_address' => $request->ip(),
                    'url' => substr($request->fullUrl(), 0, 500),
                    'user_agent' => substr((string) $request->userAgent(), 0, 500),
                    'referer' => substr((string) $request->header('referer'), 0, 500),
                ]);
            } catch (\Throwable $e) {
                // Silently ignore tracking errors so application flow is never disrupted
            }
        }

        return $response;
    }
}
