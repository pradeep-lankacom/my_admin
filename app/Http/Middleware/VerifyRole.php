<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Route;

class VerifyRole
{

    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array $roles
     * @return mixed
     *
     */
    public function handle($request, Closure $next, $roles)
    {
        //var_dump($roles->hasPermissions());exit;
        if ($this->auth->check() && $this->auth->user()->hasAnyRole($roles)) {
            return $next($request);
        }

    }
}
