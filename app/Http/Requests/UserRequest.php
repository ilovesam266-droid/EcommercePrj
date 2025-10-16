<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:125'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:125', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:1024'],
            'birthday' => ['nullable', 'date'],
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
            'role' => ['required', 'string', Rule::in(['admin', 'user'])],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a string.',
            'first_name.max' => 'First name may not be greater than 125 characters.',

            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a string.',
            'last_name.max' => 'Last name may not be greater than 255 characters.',

            'username.required' => 'Username is required.',
            'username.string' => 'Username must be a string.',
            'username.max' => 'Username may not be greater than 125 characters.',
            'username.unique' => 'This username is already taken.',

            'email.required' => 'Email address is required.',
            'email.string' => 'Email must be a string.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email may not be greater than 255 characters.',
            'email.unique' => 'This email is already registered.',

            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 5 characters.',
            'password.confirmed' => 'Password confirmation does not match.',

            'avatar.image' => 'Please upload a valid image file (jpg, png, jpeg, etc).',
            'avatar.max' => 'Your avatar must be smaller than 1MB.',

            'birthday.date' => 'Birthday must be a valid date.',

            'status.required' => 'Status is required.',
            'status.string' => 'Status must be a string.',
            'status.in' => 'Status must be either "active" or "inactive".',

            'role.required' => 'Role is required.',
            'role.string' => 'Role must be a string.',
            'role.in' => 'Role must be either "admin" or "user".',
        ];
    }
}
