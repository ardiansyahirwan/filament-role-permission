<h1>Documentation Package</h1>

- [Installation](#installation)
  - [Prerequisite](#prerequisite)
  - [Installation](#installation-1)
  - [Uninstall Package](#uninstall-package)
- [Migration File](#migration-file)
- [Admin Panel](#admin-panel)
- [Policies File](#policies-file)
- [Cluster File](#cluster-file)
- [Testing Package](#testing-package)
  - [getEnvirontmentSetUp()](#getenvirontmentsetup)
    - [Test database use getEnvirontmentSetUp()](#test-database-use-getenvirontmentsetup)
  - [Testing Variable](#testing-variable)

# Installation
this project run base on :
- Spatie/Laravel Permission
- Laravel of course
<br/>
<br/>

## Prerequisite
Copy this syntax on your ```composer.json``` file project.
```json
 "require": {
        "ardiansyahirwan/filament-role-permission":"dev-main"
    },
 "autoload": {
        "psr-4": {
            "Ardiansyahirwan\\FilamentRolePermission\\": "src"
        }
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/ardiansyahirwan/filament-role-permission"
        }
    ],
```
<br/>
<br/>

## Installation
Make sure you have done with [Prerequisite](#prerequisite) section, and you've to install filament on [filament.com](https://filamentphp.com/docs/3.x/panels/installation). After that you can go with installation package.<br>
First you can start with
```bash
composer require filament/filament:"^3.2" -W
```
and then :
```bash
composer update
```
After Installation have done run this command
```bash
php artisan vendor:publish --provider="Ardiansyahirwan\FilamentRolePermission\CustomPermissionServiceProvider" --tag="config"

// AND

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

```
Then, you can add on ```bootstap/providers.php```
```php
<?php

return [
   Spatie\Permission\PermissionServiceProvider::class,
    Ardiansyahirwan\FilamentRolePermission\CustomPermissionServiceProvider::class,
];
```

and last add on your ``app/Models/User.php``
```php
use HasRoles ;
```

Next to **[Migration File](#migration-file)**  for run and setting the **[migration](#migration-file)**
<br/>
<br/>

## Uninstall Package
Just because this package depends on ```spatie/laravel-permission``` make sure that you clean up your project from published file from ```spatie/laravel-permission```

first you can uninstall package with
```bash
composer remove ardiansyahirwan/filament-role-permission
```

and then 
```bash
rm config/filament-custom-role-permission.php
rm config/permission.php
```

make sure you remove provider on ```bootstap/providers.php```<br> remove **Spatie\Permission\PermissionServiceProvider::class** , **Ardiansyahirwan\FilamentRolePermission\CustomPermissionServiceProvider::class**
```php
<?php

return [
    App\Providers\AppServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    Ardiansyahirwan\FilamentRolePermission\CustomPermissionServiceProvider::class,
];
```

and then on folder ```database/migration``` delete **create_permission_table.php**
<br/>
<br/>

# Migration File
you must set database connection of your Laravel project. Before run the migration file, make sure you have done with [Installation](#installation-1) section.
First you can type on your terminal
```bash
php artisan migrate
```
And then run
```bash
php artisan db:customseed
```

before you run the seeder, lets make user as 'Super-Admin'. copy this to your ``app/database/seeder/DatabaseSeeder.php``
```php
// Role as Super Admin
$role = Role::create(['name' => 'Super-Admin']);

// gets all permissions via Gate::before rule; see AuthServiceProvider

// create user Super-Admin
$user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@email.com',
        ]);
$user->assignRole($role);
```
run :
```bash
php artisan db:seed
```
In your ``app/provider/AppServiceProvider`` copy this code:
```php
public function boot():void
{
    /**Unguard model for filament */
    Model::unguard();

    /**
     * Super-Admin grant all authorize
     */
    Gate::before(function ($user, $ability) {
        if ($user->hasRole('Super-Admin')) {
        return true;
        }
    });
}
```
go to **[Admin Panel Section](#admin-panel)** for next steps
<br/>
<br/>

# Admin Panel
Now make a panel for a filament with artisan command
```bash
php artisan make:filament-panel admin
```

make sure your **AdminPanelProvider.php** has registered on ``bootstrap/provider``. Open your **AdminPanelProvider.php**  and add this code.
```php
->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters');
```

before you run the terminal, you've to run this command
```bash
php artisan filament:optimize-clear

php artisan filament:optimize

php artisan filament:upgrade
```

**if you not run this command, Js and CSS filament cant reload the sources.**<br/>
 now you can run the terminal
 ```bash
 php artisan serve
 ```
<br/>
<br/>

# Policies File
for getting policies file run this command:
```bash
php artisan vendor:publish --tag="policies"
```
<br/>
<br/>

# Cluster File
for getting Filament Cluster file run this command:
```bash
php artisan vendor:publish --tag="filament-cluster"
```
<br/>
<br/>

# Testing Package
this is example file of **ExampleTest.php**
```php
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

```
for testing package you can run
```bash
vendor/bin/phpunit nameOfTestFile.php
```
<br/>
<br/>

## getEnvirontmentSetUp()
Method getEnvirontmentSetUp() actually use for configure app before running the test. this actually use for set config app, load migration or something else.

### Test database use getEnvirontmentSetUp()
```php
namespace Vendor\Package\Tests;

use Orchestra\Testbench\TestCase;
use Vendor\Package\YourServiceProvider;

class ExampleTest extends TestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            YourServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Mengatur konfigurasi database untuk pengujian
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Menjalankan migrasi untuk paket
        include_once __DIR__ . '/../database/migrations/create_example_table.php.stub';
        (new \CreateExampleTable)->up();
    }

    #[Test]
    public function it_runs_a_basic_test()
    {
        $this->assertTrue(true);
    }

    #[Test]
    public function it_tests_package_functionality()
    {
        // Tes model atau fitur lain dari paket
        $example = \Vendor\Package\Models\Example::create(['name' => 'Test']);
        
        $this->assertDatabaseHas('examples', [
            'name' => 'Test'
        ]);
    }
}

```

for example we have migration file 
``src/database/migrations/create_example_tables.php.stub``
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('examples', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('examples');
    }
};

```
and models on ``src/Models/Example.php``
```php

namespace Vendor\Package\Models;

use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    protected $fillable = ['name'];
}
```
<br/>
<br/>

## Testing Variable
you can use this for test variable on your package
```php
namespace Vendor\Package\Tests;

use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

class EnvVariableTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Set the environment variable for testing
    }

    #[Test]
    public function it_checks_env_variable_for_roles()
    {
        // Fetch the value of the environment variable
        $a = config('filament-roles.roles', ['admin', 'user']);
        
        // Assert that the value is as expected
        $this->assertEquals(['admin', 'user'], $a);
    }
}
```