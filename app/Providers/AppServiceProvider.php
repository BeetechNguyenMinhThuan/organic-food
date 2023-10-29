<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\Admin\BrandService;
use App\Services\Admin\CategoryService;
use App\Services\Admin\MenuService;
use App\Services\Admin\ProductService;
use App\Services\Admin\SliderService;
use App\Services\Admin\TagService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
