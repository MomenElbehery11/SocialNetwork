<?php
// app/Http/Middleware/EnsureUserIsActive.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->is_active) {
            return response()->json(['message' => 'Your account is inactive.'], 403);
        }

        return $next($request);
    }
}
