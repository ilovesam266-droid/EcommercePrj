<?php

namespace App\Http\Requests\Api\User;

use App\Enums\UserRole;
use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:125'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:125', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:2560'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'role' => ['required', 'string', Rule::in(UserRole::cases())],
        ];
        return $rules;
    }
}
