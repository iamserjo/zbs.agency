<?php

namespace App\Services;

use App\Models\User;

class UserRegistrationService
{
    public function register(array $data): User
    {
        // Implement the logic for user registration, including photo upload
        // Example:
        $photoPath = $data['photo']->store('photos');

        // Save the user to the database
        // Example:
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'position_id' => $data['position_id'],
            'photo' => $photoPath,
            'password' => mt_rand(),
        ]);
    }
}
