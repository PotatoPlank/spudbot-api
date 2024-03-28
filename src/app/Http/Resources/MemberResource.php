<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'total_comments' => $this->total_comments,
            'username' => $this->username,
            'guild' => new GuildResource($this->whenLoaded('guild')),
            'verified_by' => new MemberResource($this->whenLoaded('verifiedBy')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
