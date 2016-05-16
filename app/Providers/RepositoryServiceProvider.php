<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\Interfaces\ActivityRepository::class, \App\Repositories\ActivityRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\SmsVerificationCodeRepository::class, \App\Repositories\SmsVerificationCodeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\DefaultIconRepository::class, \App\Repositories\DefaultIconRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\AdRepository::class, \App\Repositories\AdRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\MarkRepository::class, \App\Repositories\MarkRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\UserMarkRepository::class, \App\Repositories\UserMarkRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\ThirdPartyRepository::class, \App\Repositories\ThirdPartyRepositoryEloquent::class);
        //:end-bindings:
    }
}
