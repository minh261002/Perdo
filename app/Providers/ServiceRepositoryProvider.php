<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceRepositoryProvider extends ServiceProvider
{
    protected $repositories = [
        'App\Repositories\BaseRepositoryInterface' => 'App\Repositories\BaseRepository',
        'App\Repositories\Module\ModuleRepositoryInterface' => 'App\Repositories\Module\ModuleRepository',
        'App\Repositories\Permission\PermissionRepositoryInterface' => 'App\Repositories\Permission\PermissionRepository',
        'App\Repositories\Role\RoleRepositoryInterface' => 'App\Repositories\Role\RoleRepository',
        'App\Repositories\Admin\AdminRepositoryInterface' => 'App\Repositories\Admin\AdminRepository',
        'App\Repositories\User\UserRepositoryInterface' => 'App\Repositories\User\UserRepository',
        'App\Repositories\Post\PostRepositoryInterface' => 'App\Repositories\Post\PostRepository',
        'App\Repositories\Post\PostCatalogueRepositoryInterface' => 'App\Repositories\Post\PostCatalogueRepository',
        'App\Repositories\Slider\SliderRepositoryInterface' => 'App\Repositories\Slider\SliderRepository',
        'App\Repositories\Slider\SliderItemRepositoryInterface' => 'App\Repositories\Slider\SliderItemRepository',
        'App\Repositories\Category\CategoryRepositoryInterface' => 'App\Repositories\Category\CategoryRepository',
        'App\Repositories\Brand\BrandRepositoryInterface' => 'App\Repositories\Brand\BrandRepository',
        'App\Repositories\Product\ProductRepositoryInterface' => 'App\Repositories\Product\ProductRepository',
        'App\Repositories\Discount\DiscountRepositoryInterface' => 'App\Repositories\Discount\DiscountRepository',
        'App\Repositories\Order\OrderRepositoryInterface' => 'App\Repositories\Order\OrderRepository',
        'App\Repositories\Transaction\TransactionRepositoryInterface' => 'App\Repositories\Transaction\TransactionRepository',
        'App\Repositories\Order\OrderItemRepositoryInterface' => 'App\Repositories\Order\OrderItemRepository',
        'App\Repositories\Notification\NotificationRepositoryInterface' => 'App\Repositories\Notification\NotificationRepository',
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->repositories as $interface => $repository) {
            $this->app->bind($interface, $repository);
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
