<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class InfoConfirm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('trainee') && !(Auth::guard('trainee')->user()->info_confirm) && \Request::route()->getName() != 'trainee.info_confirm') {
            return redirect()->route('trainee.info_confirm');
        }
        if (Auth::guard('trainee') && (Auth::guard('trainee')->user()->gender == null) && \Request::route()->getName() != 'trainee.profile') {
            return redirect()->route('trainee.profile');
        }
        return $next($request);
    }
}
