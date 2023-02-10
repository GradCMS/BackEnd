<?php

namespace App\Providers;

use App\Http\Repository\PageRepo;
use Illuminate\Support\ServiceProvider;
use App\Http\RepoInterfaces\CRUDRepoInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CRUDRepoInterface::class, PageRepo::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
