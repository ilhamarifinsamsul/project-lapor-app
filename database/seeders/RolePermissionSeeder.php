<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    private $permissions = [
        'dashboard' => ['view'],
        'user' => ['view', 'create', 'edit', 'delete'],
        'resident' => ['view', 'create', 'edit', 'delete'],
        'report-category' => ['view', 'create', 'edit', 'delete'],
        'report' => ['view', 'create', 'edit', 'delete'],
        'report-status' => ['view', 'create', 'edit', 'delete'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Buat semua permissions
        foreach ($this->permissions as $key => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $key . '-' . $action,
                    'guard_name' => 'web',
                ]);
            }
        }

        // ✅ Role Admin
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        $adminRole->givePermissionTo(Permission::all());

        // ✅ Role Resident
        $residentRole = Role::firstOrCreate([
            'name' => 'resident',
            'guard_name' => 'web',
        ]);
        $residentRole->givePermissionTo([
            'report-category-view',
            'report-view',
            'report-create',
            'report-edit',
            'report-delete',
            'report-status-view',
        ]);
    }
}
