<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $role The role(s) required to access the resource
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // First check if user is authenticated
        if (!auth()->user()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403, 'Unauthorized access');
        }

        // Get user role
        $userRole = auth()->user()->role;
        
        // Parse roles - handle both "role:admin,guru" and "admin,guru"
        $allowedRoles = [];
        
        if (strpos($role, ':') !== false) {
            // Remove "role:" prefix and split by comma
            $roleString = str_replace('role:', '', $role);
            $allowedRoles = array_map('trim', explode(',', $roleString));
        } else {
            // Direct comma-separated roles
            $allowedRoles = array_map('trim', explode(',', $role));
        }
        
        // Check if user role is allowed
        if (!in_array($userRole, $allowedRoles)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403, 'Unauthorized access');
        }
        
        $response = $next($request);
        return $response;
    }
}