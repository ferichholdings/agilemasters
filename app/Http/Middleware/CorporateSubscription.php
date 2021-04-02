<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorporateSubscription
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
        if ($request->user()->role != 'corporate')
            return redirect('/dashboard_interim')->with('success','YOU MUST BE  SUBSCRIBED TO A CORPORATE PLAN TO ACCESS THE PAGE');
        return $next($request);
    }
}
