<?php

namespace App\Http\Requests\Event;

class EventUpdateRequest extends EventRequest
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
            'discord_channel_id' => ['nullable', 'string',],
            'name' => ['string', 'required'],
            'scheduled_at' => ['date_format:Y-m-d\TH:i:sP', 'required',],
        ];
    }
}
