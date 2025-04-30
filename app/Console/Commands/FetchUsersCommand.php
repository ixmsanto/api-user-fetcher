<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class FetchUsersCommand extends Command
{
    protected $signature = 'users:fetch';
    protected $description = 'Fetch users from API and store in DB';

    public function handle()
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/users');

        if ($response->successful()) {
            $users = $response->json();

            foreach ($users as $userData) {
                User::updateOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'address' => $userData['address'] ?? [],
                    ]
                );
            }

            $this->info('Users updated successfully.');
        } else {
            $this->error('Failed to fetch users.');
        }
    }
}
