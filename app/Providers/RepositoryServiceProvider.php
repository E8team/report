<?php


namespace App\Providers;


use App\Repositories\DormitoryRepository;
use App\Repositories\DormitoryRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
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
        $this->app->singleton(DormitoryRepositoryInterface::class, function (){
            return new DormitoryRepository();
        });
        $this->app->singleton(UserRepositoryInterface::class, function (){
            return new UserRepository();
        });
    }
}