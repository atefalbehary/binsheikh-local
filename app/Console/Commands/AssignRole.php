<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-role {email} {role}';

    protected $description = 'Assign a role to a user by email';

    public function handle()
    {
        $email = $this->argument('email');
        $roleName = $this->argument('role');

        $user = \App\Models\User::where('email', $email)->first();
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }

        $role = \App\Models\Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error("Role {$roleName} not found.");
            return 1;
        }

        $user->role_id = $role->id;
        
        // Legacy role mapping for backward compatibility
        if ($roleName === 'Super Admin' || $roleName === 'Admin') {
            $user->role = '1';
        } else {
            $user->role = '2'; // or other appropriately
        }

        $user->save();

        $this->info("Role {$roleName} assigned to user {$user->name} ({$email}) successfully.");
        return 0;
    }
}
