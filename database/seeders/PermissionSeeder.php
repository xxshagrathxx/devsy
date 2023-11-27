<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Users
        Permission::create(['name'=>'show_users']);
        Permission::create(['name'=>'create_users']);
        Permission::create(['name'=>'update_users']);
        Permission::create(['name'=>'delete_users']);

        // Roles
        Permission::create(['name'=>'show_roles']);
        Permission::create(['name'=>'create_roles']);
        Permission::create(['name'=>'update_roles']);
        Permission::create(['name'=>'delete_roles']);

        // Categories
        Permission::create(['name'=>'show_categories']);
        Permission::create(['name'=>'create_categories']);
        Permission::create(['name'=>'update_categories']);
        Permission::create(['name'=>'delete_categories']);

        // SubCategories
        Permission::create(['name'=>'show_sub_categories']);
        Permission::create(['name'=>'create_sub_categories']);
        Permission::create(['name'=>'update_sub_categories']);
        Permission::create(['name'=>'delete_sub_categories']);

        // Translates
        Permission::create(['name'=>'show_translates']);
        Permission::create(['name'=>'create_translates']);
        Permission::create(['name'=>'update_translates']);
        Permission::create(['name'=>'delete_translates']);

        // Permissions
        Permission::create(['name'=>'assign_permissions']);
        Permission::create(['name'=>'update_permissions']);

        // Settings
        Permission::create(['name'=>'update_settings']);
    }
}
