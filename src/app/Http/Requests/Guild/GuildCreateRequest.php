<?php

namespace App\Http\Requests\Guild;

use App\Models\Guild;
use App\Rules\UniqueDiscordId;

class GuildCreateRequest extends GuildRequest
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
            'discord_id' => ['required', new UniqueDiscordId(Guild::query()),],
        ];
    }
}
