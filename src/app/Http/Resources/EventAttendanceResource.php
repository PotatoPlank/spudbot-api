<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventAttendanceResource extends JsonResource
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
            'no_show' => $this->no_show,
            'status' => $this->status,
            'event' => new EventResource($this->whenLoaded('event')),
            'member' => new MemberResource($this->whenLoaded('member')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
