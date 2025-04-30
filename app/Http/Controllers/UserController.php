<?php

namespace App\Http\Controllers;

// app/Http/Controllers/UserController.php

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function fetchAndStoreUsers()
    {
        try {
            $response = Http::get('https://jsonplaceholder.typicode.com/users');
            if (!$response->successful()) {
                return back()->withErrors(['error' => 'Failed to fetch users.']);
            }

            $users = $response->json();

            foreach ($users as $userData) {
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

            return redirect()->route('users.index')->with('success', 'Users updated!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'API error: ' . $e->getMessage()]);
        }
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $query->get();

        return view('users.index', compact('users'));
    }
}
