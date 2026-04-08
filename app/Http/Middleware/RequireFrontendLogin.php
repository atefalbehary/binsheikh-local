<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Marina / Skyline payment calculators: require login and allowed agency (see config/payment_calculator.php).
 */
class RequireFrontendLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->canAccessPaymentCalculators()) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
