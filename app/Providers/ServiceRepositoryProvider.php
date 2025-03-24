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
