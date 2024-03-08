<?php

namespace App\Services;

use App\Models\User;

class UserRegistrationService
{
    public function __construct(private readonly ImageService $imageService)
    {

    }

    public function register(array $data): User
    {
        $imageUrl = $this->imageService->saveImage($data['photo']);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'position_id' => $data['position_id'],
            'photo' => $imageUrl,
            'password' => mt_rand(),
        ]);
    }
}
