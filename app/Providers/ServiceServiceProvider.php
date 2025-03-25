<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected $services = [
        'App\Admin\Services\Module\ModuleServiceInterface' => 'App\Admin\Services\Module\ModuleService',
        'App\Admin\Services\Permission\PermissionServiceInterface' => 'App\Admin\Services\Permission\PermissionService',
        'App\Admin\Services\Role\RoleServiceInterface' => 'App\Admin\Services\Role\RoleService',
        'App\Admin\Services\Admin\AdminServiceInterface' => 'App\Admin\Services\Admin\AdminService',
        'App\Admin\Services\User\UserServiceInterface' => 'App\Admin\Services\User\UserService',
        'App\Admin\Services\Post\PostServiceInterface' => 'App\Admin\Services\Post\PostService',
        'App\Admin\Services\Post\PostCatalogueServiceInterface' => 'App\Admin\Services\Post\PostCatalogueService',
        'App\Admin\Services\Slider\SliderServiceInterface' => 'App\Admin\Services\Slider\SliderService',
        'App\Admin\Services\Slider\SliderItemServiceInterface' => 'App\Admin\Services\Slider\SliderItemService',
        'App\Admin\Services\Category\CategoryServiceInterface' => 'App\Admin\Services\Category\CategoryService',
        'App\Admin\Services\Brand\BrandServiceInterface' => 'App\Admin\Services\Brand\BrandService',
        'App\Admin\Services\Product\ProductServiceInterface' => 'App\Admin\Services\Product\ProductService',
        'App\Admin\Services\Discount\DiscountServiceInterface' => 'App\Admin\Services\Discount\DiscountService',
    ];
    public function register(): void
    {
        foreach ($this->services as $interface => $service) {
            $this->app->bind($interface, $service);
        }
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
