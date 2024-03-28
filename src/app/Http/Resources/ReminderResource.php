<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReminderResource extends JsonResource
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
            'description' => $this->description,
            'mention_role' => $this->mention_role,
            'scheduled_at' => $this->scheduled_at,
            'repeats' => $this->repeats,
            'guild' => new GuildResource($this->whenLoaded('guild')),
            'channel' => new ChannelResource($this->whenLoaded('channel')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
