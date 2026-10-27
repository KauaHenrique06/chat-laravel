<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable(['chat_group_message_id', 'user_id', 'read_at'])]
class ChatGroupMessageRead extends Pivot
{
    protected function casts(): array
    {
        return [
            'chat_group_message_id' => 'string',
            'user_id' => 'string',
            'read_at' => 'datetime',
        ];
    }
}
