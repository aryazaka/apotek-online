<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles ): Response
    {
        if (!Auth::check()){
            return redirect()->route('auth-management.index')->with('failed', 'Silahkan login terlebih dahulu.');
        }
        $user = Auth::user();
        if (!in_array($user->jabatan, $roles)) {
            return redirect()->back()->with('error', 'Kamu tidak punya akses ke halaman ini.');
        }
        return $next($request);
    }
}
