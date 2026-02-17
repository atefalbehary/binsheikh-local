<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RBACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create Roles
        $roles = [
            'Super Admin' => 'Full system access',
            'Admin' => 'Administrator with some restrictions',
            'Accountant Manager' => 'Finance and payment management',
            'Sales Manager' => 'Sales and client management',
            'Editor' => 'Content management only',
        ];

        $roleInstances = [];
        foreach ($roles as $name => $desc) {
            $roleInstances[$name] = \App\Models\Role::firstOrCreate(['name' => $name], ['description' => $desc]);
        }

        // 2. Define Permissions
        $permissions = [
            // Content Management
            ['name' => 'manage_content', 'module' => 'content'],
            ['name' => 'edit_content', 'module' => 'content'],
            ['name' => 'publish_scenarios', 'module' => 'content'],

            // Sales and Client
            ['name' => 'view_all_clients', 'module' => 'sales'],
            ['name' => 'edit_all_clients', 'module' => 'sales'],
            ['name' => 'create_payment_plan', 'module' => 'sales'],

            // Financial and Payment
            ['name' => 'view_finance_menu', 'module' => 'finance'],
            ['name' => 'approve_payment_plan', 'module' => 'finance'],
            ['name' => 'approve_financial_override', 'module' => 'finance'],
            ['name' => 'view_financial_audit_logs', 'module' => 'finance'],
            
            // Approval Authority
            ['name' => 'view_approval_menu', 'module' => 'approval'],
            ['name' => 'approve_general', 'module' => 'approval'],

            // Deletion Rights
            ['name' => 'delete_payment_plan', 'module' => 'deletion'],
            ['name' => 'delete_approved_payment_plan', 'module' => 'deletion'], // Super Admin only

            // Key Restrictions (Capabilities)
            ['name' => 'override_locked_record', 'module' => 'admin'],
            ['name' => 'manage_users', 'module' => 'admin'],
            ['name' => 'manage_roles', 'module' => 'admin'],
            ['name' => 'view_audit_logs', 'module' => 'admin'],
        ];

        foreach ($permissions as $perm) {
            \App\Models\Permission::firstOrCreate(['name' => $perm['name']], ['module' => $perm['module']]);
        }

        // 3. Assign Permissions
        // Super Admin gets ALL
        $allPermissions = \App\Models\Permission::all();
        $roleInstances['Super Admin']->permissions()->sync($allPermissions->pluck('id'));

        // Admin
        $adminPermissions = $allPermissions->reject(function ($perm) {
            return in_array($perm->name, ['delete_approved_payment_plan']);
        });
        $roleInstances['Admin']->permissions()->sync($adminPermissions->pluck('id'));

        // Accountant Manager
        $accountantPermissions = \App\Models\Permission::whereIn('module', ['finance', 'approval'])->get();
        $roleInstances['Accountant Manager']->permissions()->sync($accountantPermissions->pluck('id'));

        // Sales Manager
        $salesPermissions = \App\Models\Permission::whereIn('module', ['sales'])->get();
        // Add specific creation rights
        $salesPermissions = $salesPermissions->merge(\App\Models\Permission::where('name', 'create_payment_plan')->get());
        $roleInstances['Sales Manager']->permissions()->sync($salesPermissions->pluck('id'));

        // Editor
        $editorPermissions = \App\Models\Permission::where('module', 'content')->get();
        $roleInstances['Editor']->permissions()->sync($editorPermissions->pluck('id'));

        // 4. Create Default Users
        $users = [
            [
                'name' => 'Super Admin User',
                'email' => 'superadmin@binsheikh.com',
                'password' => bcrypt('password'),
                'role_id' => $roleInstances['Super Admin']->id,
                'role' => '1', // Legacy support
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@binsheikh.com',
                'password' => bcrypt('password'),
                'role_id' => $roleInstances['Admin']->id,
                'role' => '1',
            ],
            [
                'name' => 'Accountant User',
                'email' => 'accountant@binsheikh.com',
                'password' => bcrypt('password'),
                'role_id' => $roleInstances['Accountant Manager']->id,
                'role' => '2',
            ],
            [
                'name' => 'Sales User',
                'email' => 'sales@binsheikh.com',
                'password' => bcrypt('password'),
                'role_id' => $roleInstances['Sales Manager']->id,
                'role' => '2',
            ],
            [
                'name' => 'Editor User',
                'email' => 'editor@binsheikh.com',
                'password' => bcrypt('password'),
                'role_id' => $roleInstances['Editor']->id,
                'role' => '2',
            ],
        ];

        foreach ($users as $userData) {
            \App\Models\User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
