<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class UserRegistrationRequest extends FormRequest
{
    /**
     * @throws AuthorizationException
     */
    public function authorize(): bool
    {
        $token = $this->header('Authorization');

        if (!$this->validateToken($token)) {
            $this->failRegistrationToken();
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|size:13|regex:/^\+380\d{9}$/|unique:users,phone',
            'position_id' => 'required|exists:positions,id',
            'photo' => 'required|image|mimes:jpg,jpeg|dimensions:min_width=70,min_height=70|max:5120',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    protected function failRegistrationToken(): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Registration token failure',
        ], JsonResponse::HTTP_UNAUTHORIZED));
    }

    protected function validateToken($token): bool
    {
        if (!$token) {
            return false;
        }

        return Cache::has('registration_token_' . $token);
    }
}
