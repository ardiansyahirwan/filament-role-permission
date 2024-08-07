<h1>Documentation Package</h1>

- [Installation](#installation)
  - [Prerequisite](#prerequisite)
  - [Installation](#installation-1)
  - [Uninstall Package](#uninstall-package)
- [Migration File](#migration-file)
- [Testing Package](#testing-package)
  - [getEnvirontmentSetUp()](#getenvirontmentsetup)
    - [Test database use getEnvirontmentSetUp()](#test-database-use-getenvirontmentsetup)
  - [Testing Variable](#testing-variable)

# Installation
this project run base on :
- Spatie/Laravel Permission
- Filament and Dependancy
- Laravel of course
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
## Installation
Make sure you have done with [Prerequisite](#prerequisite) section, after that you can go with installation package.<br>
First you can start with 
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