<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
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
            'username' => 'string',
            'discord_id' => 'string',
            'guild' => ['uuid', 'exists:App\Models\Guild,external_id',],
            'guild_discord_id' => 'string',
            'sort' => ['string',],
            'direction' => ['string', Rule::in(['asc', 'desc'])],
            'limit' => ['numeric', 'min:1', 'max:50'],
            'total_comments' => ['nullable', 'numeric', 'min:0'],
            'verified_by_member' => ['nullable', 'uuid', 'exists:App\Models\Member,external_id'],
            'increment_comments' => ['bool', 'prohibited_unless:total_comments,null'],
        ];
    }
}
