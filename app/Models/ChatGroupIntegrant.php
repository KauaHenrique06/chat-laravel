<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable(['chat_group_id', 'user_id', 'is_admin'])]
class ChatGroupIntegrant extends Pivot
{
    protected function casts(): array
    {
        return [
            'chat_group_id' => 'string',
            'user_id' => 'string',
            'is_admin' => 'boolean',
        ];
    }
}
