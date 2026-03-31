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
            'Super Admin' => 'System owner / final decision maker',
            'Admin' => 'System operator / daily control',
            'Accountant Manager' => 'Financial validation and compliance',
            'Sales Manager' => 'Manage sales team and client flow',
            'Editor' => 'Manage website/app content and presentation',
            'Content Creator' => 'Create content (no publishing)',
        ];

        $roleInstances = [];
        foreach ($roles as $name => $desc) {
            $roleInstances[$name] = \App\Models\Role::firstOrCreate(['name' => $name], ['description' => $desc]);
        }

        // 2. Define Permissions
        $permissions = [
            // Admin Core
            ['name' => 'manage_users', 'module' => 'admin'], // Create/Manage users
            ['name' => 'manage_roles', 'module' => 'admin'],
            ['name' => 'manage_settings', 'module' => 'admin'],
            ['name' => 'view_audit_logs', 'module' => 'admin'],
            ['name' => 'override_locked_record', 'module' => 'admin'], // Super Admin only
            ['name' => 'delete_records', 'module' => 'admin'], // Super Admin generic delete

            // Content (Editor)
            ['name' => 'manage_content', 'module' => 'content'], // Edit homepage, projects, blogs
            ['name' => 'publish_content', 'module' => 'content'],

            // Sales & Clients
            ['name' => 'view_clients', 'module' => 'sales'],
            ['name' => 'edit_clients', 'module' => 'sales'],
            ['name' => 'view_visits', 'module' => 'sales'],
            ['name' => 'edit_visits', 'module' => 'sales'],
            ['name' => 'view_agents', 'module' => 'sales'], // View agents/agencies
            ['name' => 'view_agencies', 'module' => 'sales'],
            ['name' => 'approve_agency', 'module' => 'sales'], // Admin/Super Admin
            ['name' => 'reject_agency', 'module' => 'sales'],
            ['name' => 'export_data', 'module' => 'sales'],

            // Finance
            ['name' => 'view_finance_reports', 'module' => 'finance'],
            ['name' => 'view_finance_audit_logs', 'module' => 'finance'],
            ['name' => 'view_payment_plans', 'module' => 'finance'],
            ['name' => 'create_payment_plan', 'module' => 'finance'], // Sales (Draft)
            ['name' => 'generate_payment_scenarios', 'module' => 'finance'], // Admin/Sales (Draft)
            ['name' => 'publish_scenarios', 'module' => 'finance'], // Super Admin
            ['name' => 'approve_payment_plan', 'module' => 'finance'], // Super Admin
            ['name' => 'approve_financial_override', 'module' => 'finance'], // Accountant/Super Admin
            ['name' => 'delete_payment_plan', 'module' => 'finance'], // Super Admin
        ];

        foreach ($permissions as $perm) {
            \App\Models\Permission::firstOrCreate(['name' => $perm['name']], ['module' => $perm['module']]);
        }

        // 3. Assign Permissions

        // Super Admin - ALL Permissions
        $allPermissions = \App\Models\Permission::all();
        $roleInstances['Super Admin']->permissions()->sync($allPermissions->pluck('id'));

        // Admin
        // "Create and manage users (except Super Admin); Manage system data"
        // "View all agents, agencies, and clients; Export data"
        // "Create payment plan scenarios (Draft); Generate plans"
        // "Approve/reject before Super Admin"
        $adminPermissions = $allPermissions->filter(function ($perm) {
            return in_array($perm->name, [
                'manage_users',
                'manage_settings',
                'view_audit_logs',
                'manage_content',
                'publish_content',
                'view_clients',
                'edit_clients',
                'view_visits',
                'edit_visits',
                'view_agents',
                'view_agencies',
                'approve_agency',
                'reject_agency',
                'export_data',
                'view_payment_plans',
                'create_payment_plan',
                'generate_payment_scenarios'
            ]);
        });
        $roleInstances['Admin']->permissions()->sync($adminPermissions->pluck('id'));

        // Accountant Manager
        // "View audit logs related to finance only"
        // "View all payment plans; Review discounts, fees"
        // "Approve/reject financial overrides"
        $accountantPermissions = $allPermissions->filter(function ($perm) {
            return in_array($perm->name, [
                'view_finance_reports',
                'view_finance_audit_logs',
                'view_payment_plans',
                'approve_financial_override'
            ]);
        });
        $roleInstances['Accountant Manager']->permissions()->sync($accountantPermissions->pluck('id'));

        // Sales Manager
        // "View visit schedules, client history"
        // "View agents under assigned agency; View clients and visits"
        // "Create and generate payment plans using approved scenarios"
        // "Request only (Internal approval)"
        $salesPermissions = $allPermissions->filter(function ($perm) {
            return in_array($perm->name, [
                'view_clients',
                'edit_clients',
                'view_visits',
                'edit_visits',
                'view_agents',
                'view_agencies', // Can view but NOT approve
                'create_payment_plan',
                'generate_payment_scenarios'
            ]);
        });
        $roleInstances['Sales Manager']->permissions()->sync($salesPermissions->pluck('id'));

        // Editor
        // "Edit homepage, project descriptions, property listings"
        $editorPermissions = $allPermissions->filter(function ($perm) {
            return in_array($perm->name, [
                'manage_content',
                'publish_content'
            ]);
        });
        $roleInstances['Editor']->permissions()->sync($editorPermissions->pluck('id'));

        // Content Creator
        // "Create content (no publishing)"
        $contentCreatorPermissions = $allPermissions->filter(function ($perm) {
            return in_array($perm->name, [
                'manage_content',
                'publish_content',
            ]);
        });
        $roleInstances['Content Creator']->permissions()->sync($contentCreatorPermissions->pluck('id'));

        // 4. Create Default Users (Preserve existing logic or create new)
        $users = [
            [
                'name' => 'Super Admin User',
                'email' => 'superadmin@binsheikh.com',
                'password' => bcrypt('password1'),
                'role_id' => $roleInstances['Super Admin']->id,
                'role' => '1',
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
            [
                'name' => 'Content Creator User',
                'email' => 'content@binsheikh.com',
                'password' => bcrypt('password'),
                'role_id' => $roleInstances['Content Creator']->id,
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
