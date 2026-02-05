<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;

class AddTestUserAsClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find the agent (myagent@mail.com)
        $agent = User::where('email', 'myagent@mail.com')->first();
        
        if (!$agent) {
            $this->command->error('Agent with email myagent@mail.com not found!');
            return;
        }

        // Find the test user (testuser@demo.com)
        $testUser = User::where('email', 'testuser@demo.com')->first();
        
        if (!$testUser) {
            $this->command->error('User with email testuser@demo.com not found!');
            return;
        }

        // Check if this client relationship already exists
        $existingClient = Client::where('agent_id', $agent->id)
            ->where('email', 'testuser@demo.com')
            ->first();

        if ($existingClient) {
            $this->command->info('Client relationship already exists!');
            return;
        }

        // Create the client relationship
        $client = Client::create([
            'agent_id' => $agent->id,
            'client_name' => $testUser->name ?? 'Test User',
            'email' => 'testuser@demo.com',
            'country_code' => $testUser->country_code ?? '+966', // Default to Saudi Arabia if not set
            'phone' => $testUser->phone ?? '0000000000',
            'project_id' => null,
            'nationality' => null,
            'apartment_no' => null,
            'apartment_type' => null,
        ]);

        $this->command->info('Successfully added testuser@demo.com as a client for myagent@mail.com');
        $this->command->info('Client ID: ' . $client->id);
    }
}
