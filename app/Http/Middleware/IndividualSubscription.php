<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IndividualSubscription
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
        if (!$request->user()->role == 'individual' || !$request->user()->role == 'free')
            return redirect('/dashboard_interim')->with('success','YOU MUST BE  SUBSCRIBED TO AN INDIVIDUAL PLAN TO ACCESS THE PAGE');
        return $next($request);
    }
}
