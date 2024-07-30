<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;


use Closure;
use Illuminate\Http\Request;

class pc
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            return $next($request);
        }

        // dd('You are not authorized to access this page.');
        return response(view('login.login'));
        // // return abort(403);
        // return $next($request);
    }
}
