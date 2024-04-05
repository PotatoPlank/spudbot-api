<?php

namespace App\Http\Requests\Reminder;

use Illuminate\Foundation\Http\FormRequest;

class ReminderRequest extends FormRequest
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
            'guild' => ['uuid', 'exists:App\Models\Guild,external_id',],
            'channel' => ['uuid', 'exists:App\Models\Channel,external_id',],
            'has_passed' => ['date_format:Y-m-d\TH:i:sP',],
            'scheduled_at' => ['date_format:Y-m-d\TH:i:sP',],
            'mention_role' => ['nullable', 'string',],
            'repeats' => ['string',],
            'description' => ['string',],
        ];
    }
}
