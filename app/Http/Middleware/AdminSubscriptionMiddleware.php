<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role != 'admin')
            return redirect('/')->with('success','YOU MUST BE AN ADMIN TO ACCESS THE PAGE');
        return $next($request);
    }
}
