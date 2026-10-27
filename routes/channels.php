<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function (User $user, string $id) {
    return $user->id === $id;
});

Broadcast::channel('chat-group-{chatGroupId}', function (User $user, string $chatGroupId) {
    return $user->chatGroups()->whereKey($chatGroupId)->exists();
});
