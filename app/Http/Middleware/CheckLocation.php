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
        //dd($locationName);
        $location = Location::where('name',$locationName)->first();
        if (!isset($location))
            $location = Location::where('id',$locationName)->first();

        if($user->role != 'super' && !isset($location)){
            abort(403,'Enlace incorrecto o no autorizado');
        }



        //dd($location);

        if (($user->role == 'super') || (isset($user->location) && ($user->location->name == $locationName))){
            if (isset($user->location))
                $request->merge(array("location" => $location->id));
            return $next($request);
        }

        abort(403,'Usuario no autorizado');
        return redirect('/');
    }
}
