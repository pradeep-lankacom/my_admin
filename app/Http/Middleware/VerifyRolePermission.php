<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class VerifyRolePermission
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
        $this->auth = Auth::guard('admin');
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
        
        if ($this->auth->check() && $this->auth->user()->hasAnyRoleWithPermission($this->auth->user()->roles,Route::getFacadeRoot()->current()->getName())) {
            return $next($request);
        } else {
            $this->auth->logout();
            return redirect('/admin/login');
        }

    }
}
