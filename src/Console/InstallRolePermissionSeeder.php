<?php

namespace Ardiansyahirwan\FilamentRolePermission\Console;

use Ardiansyahirwan\FilamentRolePermission\Database\Seeders\CustomPermissionSeeder;
use Ardiansyahirwan\FilamentRolePermission\Database\Seeders\CustomRoleSeeder;
use Illuminate\Console\Command;

class InstallRolePermissionSeeder extends Command
{
   /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'db:customseed';

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Make a seeder for role and permission table';

   /**
    * Execute the console command.
    */
   public function handle()
   {
      $this->call(CustomRoleSeeder::class);
      $this->call(CustomPermissionSeeder::class);
   }
}
