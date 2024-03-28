<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DirectoryResource extends JsonResource
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
            'embed_id' => $this->embed_id,
            'directory_channel' => new ChannelResource($this->whenLoaded('directoryChannel')),
            'forum_channel' => new ChannelResource($this->whenLoaded('forumChannel')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
