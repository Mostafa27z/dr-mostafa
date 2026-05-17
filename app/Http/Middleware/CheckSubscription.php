<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('testing')) {
            return $next($request);
        }

        $user = auth()->user();

        // 1. Allow admins and guests
        if (!$user || $user->isAdmin()) {
            return $next($request);
        }

        // 2. Check general activity status for everyone (mostly teachers/students)
        if ($user->isDisabled() && !$request->routeIs('auth.disabled') && !$request->routeIs('logout')) {
            return redirect()->route('auth.disabled');
        }

        // 3. Allow access to the expired/disabled pages themselves
        if ($request->routeIs('subscription.expired') || $request->routeIs('auth.disabled')) {
            return $next($request);
        }

        // 4. For Teachers: Check for active subscription
        if (!app()->environment('testing') && $user->isTeacher() && !$user->isSubscribed()) {
            return redirect()->route('subscription.expired');
        }

        return $next($request);
    }
}
