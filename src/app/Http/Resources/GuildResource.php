<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuildResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'external_id' => $this->external_id,
            'discord_id' => $this->discord_id,
            'channel_announce_id' => $this->channel_announce_id,
            'channel_thread_announce_id' => $this->channel_thread_announce_id,
            'channel_public_log_id' => $this->channel_public_log_id,
            'channel_thread_public_log_id' => $this->channel_thread_public_log_id,
            'channel_mod_alert_id' => $this->channel_mod_alert_id,
            'channel_thread_mod_alert_id' => $this->channel_thread_mod_alert_id,
            'channel_introduction_id' => $this->channel_introduction_id,
            'channel_thread_introduction_id' => $this->channel_thread_introduction_id,
            'channel_marketplace_id' => $this->channel_marketplace_id,
            'channel_thread_marketplace_id' => $this->channel_thread_marketplace_id,
            'verified_members_channel_id' => $this->verified_members_channel_id,
            'verified_members_role_id' => $this->verified_members_role_id,
            'tenured_member_role_id' => $this->tenured_member_role_id,
            'member_count_channel_id' => $this->member_count_channel_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
