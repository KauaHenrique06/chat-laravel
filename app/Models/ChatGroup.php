<?php

namespace App\Models;

use App\Policies\ChatGroup\ChatGroupPolicy;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UsePolicy(ChatGroupPolicy::class)]
#[Fillable(['name', 'description'])]
class ChatGroup extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
        ];
    }

    public function integrants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, ChatGroupIntegrant::class)
            ->withPivot('is_admin')
            ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatGroupMessage::class);
    }

    public function hasIntegrant(User $user): bool
    {
        return $this->integrants()->whereKey($user->id)->exists();
    }

    public function hasAdmin(User $user): bool
    {
        return $this->integrants()->whereKey($user->id)->wherePivot('is_admin', true)->exists();
    }
}
