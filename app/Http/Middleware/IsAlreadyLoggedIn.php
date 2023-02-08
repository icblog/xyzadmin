<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IsAlreadyLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        
         if (Auth::check() &&  Auth::user()->role == 1) {
            return redirect()->route("admin.dashboard");
           }else if (Auth::check() && Auth::user()->role == 0) {
            return redirect()->route("blog.index");
           }else{
            return $next($request);
          }
    }
}