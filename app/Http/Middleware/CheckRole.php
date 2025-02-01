<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
       if (!Auth::check()) {
            return redirect()->route('home')->with('error', 'You cannot access this page');
        }


        $user = Auth::user();

        if($user->role != 'admin') {
            return redirect()->route('home')->with('error', 'You cannot access this page');
        }
        return $next($request);
    }
}