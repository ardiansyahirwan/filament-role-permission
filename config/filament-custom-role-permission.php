<?php
return [
   /**
    * List of roles on Application
    */
   'roles' => env('CUSTOM_ROLES', ['super_admin', 'admin', 'user']),

   /**
    * List of Permission on Application
    */
   'permissions' => env('CUSTOM_PERMISSION', [
      'create role',
      'edit role',
      'delete role',
      'create permission',
      'edit permission',
      'delete permission',
   ]),
];
