<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'discord_channel_id' => $this->discord_channel_id,
            'name' => $this->name,
            'type' => $this->type,
            'sesh_message_id' => $this->sesh_message_id,
            'native_event_id' => $this->native_event_id,
            'scheduled_at' => $this->scheduled_at,
            'guild' => new GuildResource($this->whenLoaded('guild')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
