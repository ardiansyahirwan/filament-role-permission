<h1>Documentation Package</h1>

- [Installation](#installation)
  - [Prerequisite](#prerequisite)
  - [Installation](#installation-1)
  - [Uninstall Package](#uninstall-package)
- [Migration File](#migration-file)

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