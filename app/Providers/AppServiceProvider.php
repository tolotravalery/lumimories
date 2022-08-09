<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application Services.
     *
     * @return void
     */
    public function register()
    {
        /*User*/
        $this->app->bind(
            'App\Repositories\IUserRepository',
            'App\Repositories\Implementations\UserRepository'
        );
        $this->app->bind(
            'App\Services\IUserService',
            'App\Services\Implementations\UserService'
        );
        /*User*/
        /*Bougie*/
        $this->app->bind(
            'App\Repositories\IBougieRepository',
            'App\Repositories\Implementations\BougieRepository'
        );
        /*Bougie*/
        /*Photo*/
        $this->app->bind(
            'App\Repositories\IPhotoRepository',
            'App\Repositories\Implementations\PhotoRepository'
        );
        $this->app->bind(
            'App\Services\IPhotoService',
            'App\Services\Implementations\PhotoService'
        );
        /*Photo*/
        /*Profil*/
        $this->app->bind(
            'App\Repositories\IProfilRepository',
            'App\Repositories\Implementations\ProfilRepository'
        );
        $this->app->bind(
            'App\Services\IProfilService',
            'App\Services\Implementations\ProfilService'
        );
        /*Profil*/
        /*Anecdote*/
        $this->app->bind(
            'App\Repositories\IAnecdoteRepository',
            'App\Repositories\Implementations\AnecdoteRepository'
        );
        $this->app->bind(
            'App\Services\IAnecdoteService',
            'App\Services\Implementations\AnecdoteService'
        );
        /*Anecdote*/
        /*Image*/
        $this->app->bind(
            'App\Services\IGeneralService',
            'App\Services\Implementations\GeneralService'
        );
        /*Image*/


    }

    /**
     * Bootstrap any application Services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
