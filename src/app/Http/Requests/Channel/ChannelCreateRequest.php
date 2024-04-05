<?php

namespace App\Http\Requests\Channel;

use App\Models\Channel;
use App\Rules\UniqueDiscordId;

class ChannelCreateRequest extends ChannelRequest
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
            'discord_id' => ['required', new UniqueDiscordId(Channel::query()),],
            'guild' => ['uuid', 'required', 'exists:App\Models\Guild,external_id'],
        ];
    }
}
