<?php

namespace App\Http\Requests\Api\User;

use App\Enums\UserRole;
use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('user');
        $rules = [
            'first_name' => ['sometimes', 'string', 'max:125'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'username' => ['sometimes', 'string', 'max:125', 'unique:users,username,'.$id],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'avatar' => ['nullable', 'image', 'max:2560'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'status' => ['sometimes', 'string', 'in:active,inactive'],
            'role' => ['sometimes', 'string', Rule::in(UserRole::cases())],
        ];
        return $rules;
    }
}
