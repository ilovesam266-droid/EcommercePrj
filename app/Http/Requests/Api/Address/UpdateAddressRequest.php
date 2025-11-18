<?php

namespace App\Http\Requests\Api\Address;

use App\Http\Requests\Api\ApiFormRequest;

class UpdateAddressRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'          => 'nullable|exists:users,id',
            'recipient_name'   => 'sometimes|required|string|max:255',
            'recipient_phone'  => 'sometimes|required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'province'         => 'nullable|string|max:255',
            'district'         => 'nullable|string|max:255',
            'ward'             => 'nullable|string|max:255',
            'detailed_address' => 'nullable|string|max:500',
            'is_default'       => 'boolean',
        ];
    }
}
