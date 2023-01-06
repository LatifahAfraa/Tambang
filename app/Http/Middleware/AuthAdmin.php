<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;

use Illuminate\Support\Facades\View;

class AuthAdmin
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        $this->authenticate($request, ['admin']);
        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guard)
    {
        if (empty($guard)) {
            $guard = [null];
        }

        if (empty(\Auth::guard('admin')->user()->id)) {
            $toko = [null];
        } else {
            $cek = \DB::table('users')->whereId(\Auth::guard('admin')->user()->id)->get();
        }

        foreach ($guard as $check => $value) {
            if ($this->auth->guard($value)->check() && $cek[$check]->level === 'Admin') {
                return $this->auth->shouldUse($value);
            }
        }

        throw new AuthenticationException(
            'Unauthenticated.', $guard, $this->redirectTo($request)
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if(!$request->expectsJson()){
            return route('login');
        }
    }
}
