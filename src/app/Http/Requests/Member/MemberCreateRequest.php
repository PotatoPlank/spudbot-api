<?php

namespace App\Http\Requests\Member;

use App\Models\Member;
use App\Rules\UniqueDiscordId;

class MemberCreateRequest extends MemberRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'discord_id' => ['required', new UniqueDiscordId(Member::query()),],
            'guild' => ['uuid', 'required', 'exists:App\Models\Guild,external_id'],
            'username' => ['string', 'required'],
            'total_comments' => ['nullable', 'numeric', 'min:0'],
            'increment_comments' => 'prohibited',
        ];
    }
}
