<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'          => 'nullable|exists:users,id',
            'recipient_name'   => 'required|string|max:255',
            'recipient_phone'  => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'province'         => 'nullable|string|max:255',
            'district'         => 'nullable|string|max:255',
            'ward'             => 'nullable|string|max:255',
            'detailed_address' => 'nullable|string|max:500',
            'is_default'       => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'recipient_name.required'  => 'Please enter the recipient\'s name.',
            'recipient_phone.required' => 'Please enter the phone number.',
            'recipient_phone.regex'    => 'Invalid phone number format.',
            'user_id.exists'           => 'User does not exist.',
        ];
    }
}
