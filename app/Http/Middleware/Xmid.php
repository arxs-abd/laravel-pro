<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Xmid
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
        if (!$request->header('X-CSRF-TOKEN')) return [
            'result' => 'You Cannot Access This Api From Other Website, Please Contact Admin to get Access 😀😀😀'
        ];
        return $next($request);
    }
}
