<?php

namespace Ardiansyahirwan\FilamentRolePermission;

use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Ardiansyahirwan\FilamentRolePermission\Console\InstallRolePermissionSeeder;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// use Illuminate\Support\ServiceProvider;

class CustomPermissionServiceProvider extends ServiceProvider
{
   // Policies File
   protected $policies = [
      Role::class => RolePolicy::class,
      Permission::class => PermissionPolicy::class,
   ];

   public function register()
   {

      // Register any application services.
      $this->mergeConfigFrom(
         __DIR__ . '/../config/custompermission.php',
         'custompermission'
      );
   }

   public function boot()
   {
      // Publish Policies File
      $this->registerPolicies();
      $this->publishes([
         __DIR__ . '/../src/Policies' => app_path('Policies'),
      ], 'policies');
      // Publish configuration file
      $this->publishes([
         __DIR__ . '/../config/custompermission.php' => config_path('custompermission.php'),
      ], 'config');

      if ($this->app->runningInConsole()) {
         $this->commands([
            InstallRolePermissionSeeder::class
         ]);
      }
   }
}
