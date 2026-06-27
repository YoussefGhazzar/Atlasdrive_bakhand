<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
class RoleOrPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $roleOrPermission
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
   public function handle(Request $request, Closure $next, string $roleOrPermission)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    if (!Auth::user()->hasRole($roleOrPermission) && !Auth::user()->hasPermissionTo($roleOrPermission)) {
        abort(403, 'wrong role ! Unauthorized.');
    }
     $userRole = auth()->user()->role;
 
        // Normalize both sides to lowercase to avoid case mismatches
        if (strtolower($userRole) !== strtolower($role)) {
            // Logged in but wrong role → redirect to their own dashboard
            return match(strtolower($userRole)) {
                'admin'  => redirect()->route('admin.dashboard'),
                'agence' => redirect()->route('agence.dashboard'),
                default  => redirect()->route('client.dashboard'),
            };
        }


    return $next($request);
}

}?>