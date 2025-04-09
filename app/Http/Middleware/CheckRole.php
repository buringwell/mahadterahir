<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
       */
    public function handle(Request $request, Closure $next, $roles)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Pisahkan roles yang diterima (misal: "admin|ustadz" menjadi ["admin", "ustadz"])
        $allowedRoles = explode('|', $roles);

        // Cek apakah pengguna memiliki salah satu role yang diizinkan
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
