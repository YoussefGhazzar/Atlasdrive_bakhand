<?php
namespace App\Http\Middleware;
use App\Http\Middleware\HandleInertiaRequests;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Middleware\RoleMiddleware;
class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $permission
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!Auth::check() || !Auth::user()->hasPermissionTo($permission)) {
            abort(403, 'Unauthorized');
        }
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('client')) {
            return redirect()->route('client.dashboard');
        } else if($user->hasRole('Agence')) {
            return redirect()->route('Agence.dashboard');
         }else {
            Auth::logout();
            return redirect('/login');
        }

        return $next($request);
    }
}


?>