<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    private $AUTH_FAILED = 'authentication_failed';

    /** перезаписываем метод handle (захвата) */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->authenticate($request, $guards) === $this->AUTH_FAILED) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Unauthorized'
            ], 400);
        }

        return $next($request);
    }

    public function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        return $this->AUTH_FAILED;
    }
//    /**
//     * Get the path the user should be redirected to when they are not authenticated.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return string|null
//     */
//    protected function redirectTo($request)
//    {
//        if (! $request->expectsJson()) {
//            return route('login');
//        }
//    }
}
