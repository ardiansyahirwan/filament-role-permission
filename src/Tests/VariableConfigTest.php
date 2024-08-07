<?php

namespace Ardiansyahirwan\FilamentRolePermission\Tests;

use Ardiansyahirwan\FilamentRolePermission\CustomPermissionServiceProvider;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

class VariableConfigTest extends TestCase
{
   /**
    * Define environment setup.
    *
    * @param  \Illuminate\Foundation\Application  $app
    * @return void
    */
   protected function getEnvironmentSetUp($app)
   {
      // Define your environment setup
      $app['config']->set('custompermission.roles', [
         'super_admin', 'admin', 'user'
      ]);

      $app['config']->set('custompermission.permissions', [
         'create role',
         'edit role',
         'delete role',
         'create permission',
         'edit permission',
         'delete permission',
      ]);
   }

   /**
    * Get package providers.
    *
    * @param \Illuminate\Foundation\Application $app
    * @return array
    */
   protected function getPackageProviders($app)
   {
      //
   }

   #[Test]
   public function config_roles_variable_test()
   {
      $roles = config('custompermission.roles');
      $expectedVariableRoles = ['super_admin', 'admin', 'user'];
      $this->assertEquals($roles, $expectedVariableRoles);
   }
   #[Test]
   public function config_permissions_variable_test()
   {
      $roles = config('custompermission.permissions');
      $expectedVariableRoles = [
         'create role',
         'edit role',
         'delete role',
         'create permission',
         'edit permission',
         'delete permission',
      ];
      $this->assertEquals($roles, $expectedVariableRoles);
   }
}
