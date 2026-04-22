<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $hrRole    = Role::firstOrCreate(['name' => 'hr']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);

        // Permissions
        $permissions = [
            'view_dashboard',
            'manage_users',
            'manage_projects',
            'manage_settings',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions
        $adminRole->syncPermissions($permissions);

        $hrRole->syncPermissions([
            'view_dashboard',
            'view_reports',
        ]);

        $staffRole->syncPermissions([
            'view_dashboard',
        ]);

        // Assign roles to users
        User::where('email', 'admin@example.com')->first()?->syncRoles('admin');
        User::where('email', 'hr@example.com')->first()?->syncRoles('hr');
        User::where('email', 'staff@example.com')->first()?->syncRoles('staff');
    }
}