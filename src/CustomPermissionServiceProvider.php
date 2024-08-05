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
      // Ensure the PermissionServiceProvider is registered.
      if ($this->app->register(PermissionServiceProvider::class)) {
         // Publish configuration file
         $this->publishes([
            __DIR__ . '/../config/filament-custom-role-permission.php' => config_path('filament-custom-role-permission.php'),
         ], 'config');

         // call seeder with artisan db:seed
         $this->callSeeder();
      }
      // Example: Add custom Filament resources
      Filament::serving(function () {
         Filament::registerNavigationItems([
            NavigationItem::make('Roles & Permissions')
               ->url(route('filament.resources.roles.index'))
               ->icon('heroicon-o-shield-check'),
         ]);
      });
   }

   protected function callSeeder()
   {
      if ($this->app->runningInConsole()) {
         $this->publishPermission();
         $this->loadSeeder();
      }
   }

   protected function publishPermission()
   {
      Artisan::call('vendor:publish', [
         '--provider' => "Spatie\\Permission\\PermissionServiceProvider",
      ]);
   }

   protected function loadSeeder()
   {
      Artisan::call('db:seed', [
         '--class' => "Ardiansyahirwan\\FilamentRolePermission\\Src\\Database\\Seeders\\CustomRoleSeeder",
      ]);
      Artisan::call('db:seed', [
         '--class' => "Ardiansyahirwan\\FilamentRolePermission\\Src\\Database\\Seeders\\CustomPermissionSeeder",
      ]);
   }
}
