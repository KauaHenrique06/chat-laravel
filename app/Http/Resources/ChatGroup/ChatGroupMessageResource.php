<?php

namespace App\Http\Resources\ChatGroup;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\ChatGroupMessage
 */
class ChatGroupMessageResource extends JsonResource
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
            'body' => $this->body,
            'chat_group_id' => $this->chat_group_id,
            'user' => $this->whenLoaded('user', fn () => new UserResource($this->user)),
            'readers' => ChatGroupMessageReadResource::collection($this->whenLoaded('readers')),
            'created_at' => $this->created_at,
        ];
    }
}
