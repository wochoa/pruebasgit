<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MyEnsureEmailIsVerified
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
        return $next($request);
    }
    // public function handle($request, Closure $next)
    // {
    //     if (! $request->user() ||
    //         ($request->user() instanceof MustVerifyEmail &&
    //         ! $request->user()->hasVerifiedEmail())) {
    //         return $request->expectsJson()
    //                 ? abort(403, 'Your email address is not verified.') // replace with your message, or path to translation
    //                 : Redirect::route('verification.notice');
    //     }

    //     return $next($request);
    // }
}
