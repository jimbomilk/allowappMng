<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $locationName = Route::current()->parameters['location'];


        $location = Auth::user()->location;


        if (!isset($location)){
            abort(403,'Usuario no autorizado');
            return redirect('/');
        }

        $request->merge(array("location" => $location->id));
        return $next($request);
    }
}
