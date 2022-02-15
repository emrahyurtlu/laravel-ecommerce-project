<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            return parent::handle($request, $next, $guards);
        } else {
            return Redirect::to("/giris");
        }
    }
}
