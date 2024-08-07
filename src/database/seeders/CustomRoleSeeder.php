<?php

namespace Ardiansyahirwan\FilamentRolePermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CustomRoleSeeder extends Seeder
{
   public function run(): void
   {
      $arrayRoles = config('custompermission.roles');
      $roles = collect($arrayRoles)->map(function ($role) {
         return ['name' => $role, 'guard_name' => 'web'];
      });
      Role::insert($roles->toArray());
   }
}
