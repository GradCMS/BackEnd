<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        $this->orderMigrations();
    }
    protected function orderMigrations()
    {
        $migrations = collect(File::glob(database_path('migrations/*.php')))
            ->map(function ($path) {
                $fileName = basename($path);
                $migrationName = str_replace('.php', '', $fileName);
                $parts = explode('_', $migrationName);
                $order = (int)array_shift($parts);
                return (object) [
                    'path' => $path,
                    'fileName' => $fileName,
                    'migrationName' => $migrationName,
                    'order' => $order
                ];
            })
            ->sortBy('order')
            ->pluck('path')
            ->toArray();

        foreach ($migrations as $migration) {
            require_once $migration;
        }
    }
}
