<?php

namespace Ardiansyahirwan\FilamentRolePermission\Tests;

use Ardiansyahirwan\FilamentRolePermission\CustomPermissionServiceProvider;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ExampleTest extends TestCase
{
   /**
    * Define environment setup.
    *
    * @param  \Illuminate\Foundation\Application  $app
    * @return void
    */
   protected function getEnvironmentSetUp($app)
   {
      // Define your environment setup.
   }

   /**
    * Get package providers.
    *
    * @param \Illuminate\Foundation\Application $app
    * @return array
    */
   protected function getPackageProviders($app)
   {
      return [
         CustomPermissionServiceProvider::class,
      ];
   }

   #[Test]
   public function it_runs_a_basic_test()
   {
      $this->assertTrue(true);
   }
}
