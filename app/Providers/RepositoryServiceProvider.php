<?php

namespace App\Providers;

use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Http\Repository\CssClassRepo;
use App\Http\Repository\DisplayRepo;
use App\Http\Repository\GridSettingRepo;
use App\Http\Repository\ModuleRepo;
use App\Http\Repository\PageRepo;
use App\Http\Repository\PermissionRepo;
use App\Http\Repository\RoleRepo;
use App\Http\Repository\SliderSettingRepo;
use Illuminate\Support\ServiceProvider;
use App\Http\RepoInterfaces\RepositoryRegistery;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RepoRegisteryInterface::class, RepositoryRegistery::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $registery = RepositoryRegistery::getInstance();

        /* register all the concrete class with keys here */

        $registery->register('page', new PageRepo());
        $registery->register('css_class', new CssClassRepo());
        $registery->register('display', new DisplayRepo());
        $registery->register('grid_settings', new GridSettingRepo());
        $registery->register('module', new ModuleRepo());
        $registery->register('slider_settings', new SliderSettingRepo());
        $registery->register('role', new RoleRepo());
        $registery->register('permission', new PermissionRepo());
    }
}
