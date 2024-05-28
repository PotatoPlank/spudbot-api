<?php

namespace App\Http\Requests\Guild;

use Illuminate\Foundation\Http\FormRequest;

class GuildRequest extends FormRequest
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
            'discord_id' => ['string',],
            'channel_announce_id' => [],
            'channel_thread_announce_id' => [],
            'channel_public_log_id' => [],
            'channel_thread_public_log_id' => [],
            'channel_mod_alert_id' => [],
            'channel_thread_mod_alert_id' => [],
            'channel_introduction_id' => [],
            'channel_thread_introduction_id' => [],
            'channel_marketplace_id' => [],
            'channel_thread_marketplace_id' => [],
            'verified_members_channel_id' => [],
            'verified_members_role_id' => [],
            'tenured_member_role_id' => [],
        ];
    }
}
