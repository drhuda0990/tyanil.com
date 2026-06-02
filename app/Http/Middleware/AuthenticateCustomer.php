<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('customer')->check()) {
            if ((Auth::guard('customer')->user()->email==null || Auth::guard('customer')->user()->name==null) && (\Request::route()->getName() != 'customer.info'&&\Request::route()->getName() != 'customer.info.post')) {
                return  redirect()->route('customer.info');
            }
            return $next($request);
        }

        return redirect(route('customer.login'));
    }
}
