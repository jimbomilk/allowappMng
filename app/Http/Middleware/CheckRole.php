<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {

        $type = Auth::user()->profile->type;

        if ($this->roleVal($type)<$this->roleVal($role)){
            abort(403,'Usuario no autorizado');
            return redirect('/');
        }

        return $next($request);
    }

    private function roleVal($rol){
        switch($rol){
            case "super":return 100;
            case "admin":return 50;
            case "owner":return 10;
        }
        return 1;
    }
}
