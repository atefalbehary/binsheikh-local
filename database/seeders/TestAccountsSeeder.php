<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestAccountsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     *
     * @return void
     */
    public function run()
    {
        // Test User Account (Role 2)
        User::create([
            'name' => 'Test User',
            'email' => 'testuser@demo.com',
            'password' => Hash::make('password123'),
            'phone' => '11111111',
            'dial_code' => '+974',
            'role' => '2',
            'active' => 1,
            'verified' => 1,
            'phone_verified' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Test Agent Account (Role 3)
        User::create([
            'name' => 'Test Agent',
            'email' => 'testagent@demo.com',
            'password' => Hash::make('password123'),
            'phone' => '22222222',
            'dial_code' => '+974',
            'role' => '3',
            'active' => 1,
            'verified' => 1,
            'phone_verified' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Test Agency Account (Role 4)
        User::create([
            'name' => 'Test Agency',
            'email' => 'testagency@demo.com',
            'password' => Hash::make('password123'),
            'phone' => '33333333',
            'dial_code' => '+974',
            'role' => '4',
            'active' => 1,
            'verified' => 1,
            'phone_verified' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "✅ Test accounts created successfully!\n\n";
        echo "════════════════════════════════════════════════════════\n";
        echo "📧 TEST USER ACCOUNT (Regular User)\n";
        echo "════════════════════════════════════════════════════════\n";
        echo "Email:    testuser@demo.com\n";
        echo "Password: password123\n";
        echo "Role:     User (2)\n\n";

        echo "════════════════════════════════════════════════════════\n";
        echo "📧 TEST AGENT ACCOUNT\n";
        echo "════════════════════════════════════════════════════════\n";
        echo "Email:    testagent@demo.com\n";
        echo "Password: password123\n";
        echo "Role:     Agent (3)\n\n";

        echo "════════════════════════════════════════════════════════\n";
        echo "📧 TEST AGENCY ACCOUNT\n";
        echo "════════════════════════════════════════════════════════\n";
        echo "Email:    testagency@demo.com\n";
        echo "Password: password123\n";
        echo "Role:     Agency (4)\n\n";
    }
}
