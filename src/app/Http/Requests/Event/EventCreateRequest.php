<?php

namespace App\Http\Requests\Event;

use Illuminate\Validation\Rule;

class EventCreateRequest extends EventRequest
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
            'guild' => ['required', 'uuid', 'exists:App\Models\Guild,external_id'],
            'discord_channel_id' => ['nullable', 'string'],
            'name' => ['string', 'required'],
            'type' => [Rule::in(['SESH', 'NATIVE'], 'required')],
            'sesh_id' => ['nullable', 'string',],
            'native_id' => ['nullable', 'string',],
            'scheduled_at' => ['date_format:Y-m-d\TH:i:sP', 'required',],
        ];
    }
}
