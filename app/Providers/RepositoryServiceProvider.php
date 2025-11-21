<?php

namespace App\Providers;

use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\ResidentRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Repositories\ResidentRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ReportCategoryInterface;
use App\Interfaces\ReportRepositoryInterface;
use App\Repositories\ReportCategoryRepository;
use App\Repositories\ReportRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthRepositoryInterface::class,
            AuthRepository::class,
        );
        $this->app->bind(
            ResidentRepositoryInterface::class,
            ResidentRepository::class
        );
        $this->app->bind(
            ReportCategoryInterface::class,
            ReportCategoryRepository::class
        );
        $this->app->bind(
            ReportRepositoryInterface::class,
            ReportRepository::class
        );

        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
