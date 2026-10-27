<?php

namespace App\Http\Resources\ChatGroup;

use App\Models\ChatGroupIntegrant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * User loaded through ChatGroup::integrants()
 *
 * @mixin \App\Models\User
 */
class ChatGroupIntegrantResource extends JsonResource
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
            'email' => $this->email,
            'is_admin' => $this->whenPivotLoaded(ChatGroupIntegrant::class, fn () => $this->pivot->is_admin),
            'joined_at' => $this->whenPivotLoaded(ChatGroupIntegrant::class, fn () => $this->pivot->created_at),
        ];
    }
}
