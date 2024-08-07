<?php

namespace Ardiansyahirwan\FilamentRolePermission;

use Ardiansyahirwan\FilamentRolePermission\Console\InstallRolePermissionSeeder;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Artisan;

class CustomPermissionServiceProvider extends ServiceProvider
{
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
