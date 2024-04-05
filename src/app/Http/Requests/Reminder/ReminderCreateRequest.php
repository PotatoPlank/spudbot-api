<?php

namespace App\Http\Requests\Reminder;

class ReminderCreateRequest extends ReminderRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'guild' => ['required', 'uuid', 'exists:App\Models\Guild,external_id',],
            'channel' => ['required', 'uuid', 'exists:App\Models\Channel,external_id',],
            'description' => ['string', 'required',],
            'mention_role' => ['nullable', 'string',],
            'scheduled_at' => ['date_format:Y-m-d\TH:i:sP', 'required',],
            'repeats' => ['nullable', 'string',],
        ];
    }
}
