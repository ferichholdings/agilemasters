<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstructorMiddleware
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
        if ($request->user()->role != 'instructor')
            return redirect('/dashboard_interim')->with('success','YOU MUST BE AN INSTRUCTOR TO ACCESS THE PAGE');
        return $next($request);
    }
}
