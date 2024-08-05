<?php

namespace Ardiansyahirwan\FilamentRolePermission;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CustomPermissionSeeder extends Seeder
{
   public function run(): void
   {
      $permissionsOfArray = [
         'create stadions',
         'edit stadions',
         'delete stadions',
         'create teams',
         'edit teams',
         'delete teams',
         'create match teams',
         'edit match teams',
         'delete match teams',
      ];

      $permissions = collect($permissionsOfArray)
         ->map(fn ($permission) => ['name' => $permission, 'guard_name' => 'web']);
      Permission::insert($permissions->toArray());
   }
}
