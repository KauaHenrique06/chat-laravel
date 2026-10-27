<?php

namespace App\Models;

use App\Policies\ChatGroup\ChatGroupMessagePolicy;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[UsePolicy(ChatGroupMessagePolicy::class)]
#[Fillable(['body', 'chat_group_id', 'user_id'])]
class ChatGroupMessage extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'body' => 'string',
            'chat_group_id' => 'string',
            'user_id' => 'string',
        ];
    }

    public function chatGroup(): BelongsTo
    {
        return $this->belongsTo(ChatGroup::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function readers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, ChatGroupMessageRead::class)
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
