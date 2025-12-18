<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Permission\Models\Permission;
use Modules\Roles\Models\Role;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);
        $permissions = [
            // User Management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Role Management
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',

            // Permission Management
            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',

            // Post Management
            'post.view',
            'post.create',
            'post.edit',
            'post.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'module' => 'Super Admin']);
        }

        // Super Admin - Full Access
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - Most Access
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo([
            'user.view',
            'user.create',
            'user.edit',
            'role.view',
            'permission.view',
            'post.view',
            'post.create',
            'post.edit',
            'post.delete',
        ]);

        // Editor - Limited Access
        $editor = Role::create(['name' => 'Editor']);
        $editor->givePermissionTo([
            'post.view',
            'post.create',
            'post.edit',
        ]);

        // User - Basic Access
        $user = Role::create(['name' => 'User']);
        $user->givePermissionTo(['post.view']);

        // Create Users dengan Role
        $superAdminUser = \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
        ]);
        $superAdminUser->assignRole('Super Admin');

        $adminUser = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole('Admin');

        $editorUser = \App\Models\User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => bcrypt('password'),
        ]);
        $editorUser->assignRole('Editor');

        // User dengan direct permission (tanpa role)
        $normalUser = \App\Models\User::create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $normalUser->assignRole('User');
        $normalUser->givePermissionTo('post.create');
    }
}
