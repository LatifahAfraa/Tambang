<?php

namespace App\Http\Middleware;

use Closure;use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;

use Illuminate\Support\Facades\View;
class Operator2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * 
     * 
     */
    protected $auth;
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }


    public function handle($request, Closure $next)
    {
        $this->authenticate($request, ['admin']);
        return $next($request);
    }

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
            if ($this->auth->guard($value)->check() && $cek[$check]->level === 'Operator2') {
                return $this->auth->shouldUse($value);
            }
        }

        throw new AuthenticationException(
            'Unauthenticated.', $guard, $this->redirectTo($request)
        );
    }

    protected function redirectTo($request)
    {
        if(!$request->expectsJson()){
            return route('login');
        }
    }

}
