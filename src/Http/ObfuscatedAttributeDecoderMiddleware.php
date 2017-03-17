<?php

namespace DBonner\Identifier\Http;

use Closure;
use DBonner\Identifier\PrimeId;
use Illuminate\Support\Facades\Auth;

class ObfuscatedAttributeDecoderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        collect(config('identifier.cast.prime', []))->filter(function ($key) use ($request) {
            return $request->has($key);
        })->each(function ($key) use ($request) {
            $request->offsetSet($key, PrimeId::decode($request->get($key))->toString());
        });

        return $next($request);
    }
}
