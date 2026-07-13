<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPesertaSessionCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        config(['session.cookie' => 'peserta_session']);
        return $next($request);
    }
}