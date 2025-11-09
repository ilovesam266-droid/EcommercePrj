<?php

namespace App\Http\Requests;

use App\Enums\NotificationType;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
    public function rules(string $type = 'create', $id = null): array
    {
        $rules =  [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => ['required', new Enum(NotificationType::class)],
            'variables' => 'nullable',
            'scheduled_at' => 'nullable|date|after_or_equal:now',
        ];
        if($type !== 'create' && $id){
            $rules['name'] = ['required', 'string', 'max:255', 'unique:mails,name,'.$id];
        }
        return $rules;
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Please enter the notification subject.',
            'title.max' => 'The subject may not be greater than 255 characters.',
            'body.required' => 'Please enter the notification content.',
            'type.required' => 'Please select an notification type.',
            'type.enum' => 'The selected notification type is invalid.',
            'variables.array' => 'The variables field must be a valid array.',
            'scheduled_at.date' => 'The scheduled time must be a valid date.',
            'scheduled_at.after_or_equal' => 'The scheduled time must be equal to or later than the current time.',
        ];
    }
}
