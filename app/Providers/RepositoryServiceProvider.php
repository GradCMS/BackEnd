<?php

namespace App\Providers;

use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Http\RepoInterfaces\RepositoryRegistery;
use App\Http\Repository\Auth\PermissionRepo;
use App\Http\Repository\Auth\RoleRepo;
use App\Http\Repository\CssClassRepo;
use App\Http\Repository\DisplayRepo;
use App\Http\Repository\GridSettingRepo;
use App\Http\Repository\ModuleRepo;
use App\Http\Repository\NavbarRepo;
use App\Http\Repository\PageRepo;
use App\Http\Repository\SiteIdentityRepo;
use App\Http\Repository\SliderSettingRepo;
use App\Http\Repository\UserRepo;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RepoRegisteryInterface::class, RepositoryRegistery::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
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
        $registery->register('user', new UserRepo());
        $registery->register('site_identity', new SiteIdentityRepo());
        $registery->register('nav_bar', new NavbarRepo());
    }
}
