<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                    return redirect('pc/dashboard');
                } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                    // dd(Auth::user()->gocap_id_upzis_pengurus);
                    return redirect('upzis/dashboard');
                } elseif (Auth::user()->gocap_id_ranting_pengurus != NULL) {
                    // dd(Auth::user()->gocap_id_ranting_pengurus);
                    return redirect('ranting/dashboard');
                } else {
                    return back()->withErrors([
                        'password' => 'Wrong No HP or Password',
                    ]);
                }
            }
        }

        return $next($request);
    }
}
