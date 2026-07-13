<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetGuruSessionCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        config(['session.cookie' => 'guru_session']);
        return $next($request);
    }
}