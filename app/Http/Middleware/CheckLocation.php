<?php

namespace App\Http\Middleware;

use App\Location;
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
        $user = Auth::user();
        $locationName = Route::current()->parameters['location'];
        $location = Location::where('name',$locationName)->first();
        if(!isset($location)){
            $location = Location::where('id',$locationName)->first();
        }
        if(!isset($location)){
            Auth::logout();
            //abort(403,'Enlace incorrecto o no autorizado');
        }

        if (($user->role == 'super') || (isset($user->location) && ($user->location->name == $location->name))){
            if (isset($user->location))
                $request->merge(array("location" => $location->id));
            return $next($request);
        }

        Auth::logout();
        //return redirect('/');
    }
}
