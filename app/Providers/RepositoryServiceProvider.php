<?php

namespace App\Providers;

use App\Http\Repository\PageRepo;
use App\Http\Repository\PermissionRepo;
use App\Models\Page;
use http\Env;
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
        $this->app->bind(CRUDRepoInterface::class, PermissionRepo::class);
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
