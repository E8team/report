<?php


namespace App\Providers;


use App\Repositories\DepartmentClassInfoRepository;
use App\Repositories\DepartmentClassInfoRepositoryInterface;
use App\Repositories\DepartmentClassRepository;
use App\Repositories\DepartmentClassRepositoryInterface;
use App\Repositories\DormitoryRepository;
use App\Repositories\DormitoryRepositoryInterface;
use App\Repositories\LogRepository;
use App\Repositories\LogRepositoryInterface;
use App\Repositories\StudentRepository;
use App\Repositories\StudentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DormitoryRepositoryInterface::class, function () {
            return new DormitoryRepository();
        });

        $this->app->singleton(StudentRepositoryInterface::class, function () {
            return new StudentRepository();
        });

        $this->app->singleton(DepartmentClassRepositoryInterface::class, function () {
            return new DepartmentClassRepository();
        });

        $this->app->singleton(DepartmentClassInfoRepositoryInterface::class, function () {
            return new DepartmentClassInfoRepository();
        });

        $this->app->singleton(LogRepositoryInterface::class, function () {
            return new LogRepository();
        });
    }
}