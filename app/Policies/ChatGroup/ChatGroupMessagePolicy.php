<?php

namespace App\Policies\ChatGroup;

use App\Models\ChatGroupMessage;
use App\Models\User;

/**
 * Only the author edits the message, the author or a group admin deletes it.
 */
class ChatGroupMessagePolicy
{
    /**
     * Determine whether the user can update the message.
     */
    public function update(User $authUser, ChatGroupMessage $message): bool
    {
        return $authUser->id === $message->user_id;
    }

    /**
     * Determine whether the user can delete the message.
     */
    public function delete(User $authUser, ChatGroupMessage $message): bool
    {
        return $authUser->id === $message->user_id || $message->chatGroup->hasAdmin($authUser);
    }
}
