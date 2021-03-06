<?php

namespace App\Providers;

use App\Group;
use App\Location;
use App\Observers\GroupObserver;
use App\Observers\LocationObserver;
use App\Observers\PersonObserver;
use App\Observers\PhotoObserver;
use App\Person;
use App\Photo;
use App\Services\EmailValidator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        Location::observe(LocationObserver::class);
        Group::observe(GroupObserver::class);
        Person::observe(PersonObserver::class);
        Photo::observe(PhotoObserver::class);

        Validator::extend('rightholders', function($attribute, $value, $parameters,$validator){
            return EmailValidator::validate_rhs($attribute, $value, $parameters,$validator);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            //$this->app->register(DuskServiceProvider::class);
        }
    }
}
