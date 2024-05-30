<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarketplaceResource extends JsonResource
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
            'last_status' => $this->last_status,
            'discord_id' => $this->discord_id,
            'name' => $this->name,
            'tags' => $this->tags,
            'member' => new MemberResource($this->whenLoaded('member')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
