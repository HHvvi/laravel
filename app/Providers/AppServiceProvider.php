<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('mobile', function($attribute, $value, $parameters){
            return preg_match("/^1[34578]{1}\d{9}$/",$value);
        });
        Validator::extend('account', function($attribute, $value, $parameters){
            return preg_match("/^1[34578]{1}\d{9}$/",$value)||preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i",$value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
