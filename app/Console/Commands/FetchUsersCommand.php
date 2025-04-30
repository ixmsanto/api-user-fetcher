<?php

namespace App\Console\Commands;

// app/Console/Commands/FetchUsersCommand.php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class FetchUsersCommand extends Command
{
    protected $signature = 'users:fetch';
    protected $description = 'Fetch users from API and store in DB';

    public function handle()
    {
        try {
            $response = Http::timeout(10)->get('https://jsonplaceholder.typicode.com/users');

            if (!$response->successful()) {
                $this->error('API request failed with status code: ' . $response->status());
                Log::error('API request failed', ['status' => $response->status()]);
                return;
            }

            $users = $response->json();

            if (!is_array($users)) {
                $this->error('Unexpected API response format.');
                Log::error('API response is not an array', ['response' => $users]);
                return;
            }

            foreach ($users as $userData) {
                if (!isset($userData['email'], $userData['name'], $userData['address'])) {
                    Log::warning('Skipping user due to missing fields', ['user' => $userData]);
                    continue;
                }

                $address = [
                    'street' => $userData['address']['street'] ?? '',
                    'suite' => $userData['address']['suite'] ?? '',
                    'city' => $userData['address']['city'] ?? '',
                    'zipcode' => $userData['address']['zipcode'] ?? '',
                    'geo' => $userData['address']['geo'] ?? ['lat' => '', 'lng' => ''],
                ];

                User::updateOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'address' => $address,
                    ]
                );
            }

            $this->info('Users updated successfully.');

        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            Log::error('Error in FetchUsersCommand', ['exception' => $e]);
            Log::info('Address:', [$address]);
        }
    }
}
