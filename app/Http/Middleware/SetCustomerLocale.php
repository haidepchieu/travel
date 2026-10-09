<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetCustomerLocale
{
    /**
     * The customer-facing site is English only; the Filament admin panel keeps the default (vi) locale.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Livewire requests only come from the admin panel, so they keep the admin locale too
        if (! $request->is('admin', 'admin/*', 'livewire/*')) {
            App::setLocale('en');
        }

        return $next($request);
    }
}
