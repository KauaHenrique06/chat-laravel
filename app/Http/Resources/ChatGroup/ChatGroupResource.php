<?php

namespace App\Http\Resources\ChatGroup;

use App\Models\ChatGroupIntegrant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\ChatGroup
 */
class ChatGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            // Only when loaded through User::chatGroups()
            'is_admin' => $this->whenPivotLoaded(ChatGroupIntegrant::class, fn () => $this->pivot->is_admin),
            'integrants' => ChatGroupIntegrantResource::collection($this->whenLoaded('integrants')),
            'messages' => ChatGroupMessageResource::collection($this->whenLoaded('messages')),
            'created_at' => $this->created_at,
        ];
    }
}
