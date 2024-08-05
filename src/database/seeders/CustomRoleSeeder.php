<?php

namespace Ardiansyahirwan\FilamentRolePermission;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CustomRoleSeeder extends Seeder
{
   public function run(): void
   {
      $arrayRoles = ['super_admin', 'admin', 'member'];
      $roles = collect($arrayRoles)->map(function ($role) {
         return ['name' => $role, 'guard_name' => 'web'];
      });
      Role::insert($roles->toArray());
   }
}
