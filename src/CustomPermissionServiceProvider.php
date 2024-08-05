<?php

namespace Ardiansyahirwan\FilamentRolePermission;

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
         __DIR__ . '/../config/filament-custom-role-permission.php',
         'filament-custom-role-permission'
      );
   }

   public function boot()
   {
      // Boot any application services.
      // Here you can perform actions after all services have been registered.

      // Ensure the PermissionServiceProvider is registered.
      $this->app->register(PermissionServiceProvider::class);

      // Example: Add custom Filament resources
      Filament::serving(function () {
         Filament::registerNavigationItems([
            NavigationItem::make('Roles & Permissions')
               ->url(route('filament.resources.roles.index'))
               ->icon('heroicon-o-shield-check'),
         ]);
      });

      // Publish configuration file
      $this->publishes([
         __DIR__ . '/../config/filament-custom-role-permission.php' => config_path('filament-custom-role-permission.php'),
      ], 'config');

      // call seeder with artisan db:seed
      $this->callSeeder();
   }

   protected function callSeeder()
   {
      if ($this->app->runningInConsole()) {
         $this->loadSeeder();
      }
   }

   protected function loadSeeder()
   {
      Artisan::call('db:seed', [
         '--class' => [
            'Ardiansyahirwan\\FilamentCustomRolePermission\\Database\\Seeders\\CustomPermissionSeeder',
            'Ardiansyahirwan\\FilamentCustomRolePermission\\Database\\Seeders\\CustomRoleSeeder',
         ]
      ]);
   }
}
