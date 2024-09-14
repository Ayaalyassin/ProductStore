<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserRepository();
        });

        $this->app->singleton(UserService::class, function ($app) {

            return new UserService($app->make(UserRepository::class));
        });

        $this->app->singleton(CategoryRepository::class, function ($app) {
            return new CategoryRepository();
        });

        $this->app->singleton(CategoryService::class, function ($app) {

            return new CategoryService($app->make(CategoryRepository::class));
        });

        $this->app->singleton(CommentRepository::class, function ($app) {
            return new CommentRepository();
        });

        $this->app->singleton(CommentService::class, function ($app) {

            return new CommentService($app->make(CommentRepository::class));
        });

        $this->app->singleton(ProductRepository::class, function ($app) {
            return new ProductRepository();
        });

        $this->app->singleton(ProductService::class, function ($app) {

            return new ProductService($app->make(ProductRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
