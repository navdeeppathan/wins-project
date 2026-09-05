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
        $user = auth()->user();

        // If not authenticated, let auth middleware handle it
        if (!$user) {
            return $next($request);
        }

        // Super Admin always has unrestricted full access
        if (in_array($user->role, ['super_admin', 'superadmin'])) {
            return $next($request);
        }

        // Exempt routes (subscription purchase, checkout, history, logout)
        if ($request->routeIs('subscription.*') ||
            $request->routeIs('admin.subscription.*') ||
            $request->is('subscription*') ||
            $request->is('admin/subscription*') ||
            $request->is('logout') ||
            $request->routeIs('logout')) {
            return $next($request);
        }

        // Check if user or their organization has an active non-expired plan
        if (!$user->hasActivePlan()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your subscription plan is inactive or expired. Please purchase or renew a subscription to access protected features.',
                    'redirect_url' => route('subscription.index')
                ], 403);
            }

            return redirect()->route('subscription.index')
                ->with('warning', 'Access Restricted: You need an active subscription plan to access this feature. Please choose a plan below and complete payment.');
        }

        return $next($request);
    }
}
