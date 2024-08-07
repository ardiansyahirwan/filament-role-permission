<?php

namespace Ardiansyahirwan\FilamentRolePermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CustomPermissionSeeder extends Seeder
{
   public function run(): void
   {
      $permissionsOfArray = config('custompermission.permissions');

      $permissions = collect($permissionsOfArray)
         ->map(fn ($permission) => ['name' => $permission, 'guard_name' => 'web']);
      Permission::insert($permissions->toArray());
   }
}
