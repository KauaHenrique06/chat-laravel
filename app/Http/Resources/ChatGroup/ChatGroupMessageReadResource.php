<?php

namespace App\Http\Resources\ChatGroup;

use App\Models\ChatGroupMessageRead;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * User loaded through ChatGroupMessage::readers()
 *
 * @mixin \App\Models\User
 */
class ChatGroupMessageReadResource extends JsonResource
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
            'read_at' => $this->whenPivotLoaded(ChatGroupMessageRead::class, fn () => $this->pivot->read_at),
        ];
    }
}
