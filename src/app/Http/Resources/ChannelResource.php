<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
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
            'guild' => new GuildResource($this->whenLoaded('guild')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
