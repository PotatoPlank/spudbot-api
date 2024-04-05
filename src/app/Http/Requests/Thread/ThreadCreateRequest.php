<?php

namespace App\Http\Requests\Thread;

use App\Models\Thread;
use App\Rules\UniqueDiscordId;

class ThreadCreateRequest extends ThreadRequest
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
            'discord_id' => ['required', new UniqueDiscordId(Thread::query()),],
            'guild' => ['required', 'uuid', 'exists:App\Models\Guild,external_id'],
            'channel' => ['required', 'uuid', 'exists:App\Models\Channel,external_id'],
        ];
    }
}
