<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubscriptionMiddleware
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
        if ($request->user()->status != 'subscribed')
            return redirect('/dashboard_interim')->with('success','YOU MUST HAVE AN ACTIVE SUBSCRIPTION PLAN TO ACCESS THE PAGE');
        return $next($request);
    }
}
