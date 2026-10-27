<?php

namespace App\Policies\ChatGroup;

use App\Models\ChatGroup;
use App\Models\User;

/**
 * Integrants can view the group and send messages, only admins manage it.
 */
class ChatGroupPolicy
{
    /**
     * Determine whether the user can view the group.
     * Obs: show, integrants and messages index
     */
    public function view(User $authUser, ChatGroup $chatGroup): bool
    {
        return $chatGroup->hasIntegrant($authUser);
    }

    /**
     * Determine whether the user can update the group.
     */
    public function update(User $authUser, ChatGroup $chatGroup): bool
    {
        return $chatGroup->hasAdmin($authUser);
    }

    /**
     * Determine whether the user can delete the group.
     */
    public function delete(User $authUser, ChatGroup $chatGroup): bool
    {
        return $chatGroup->hasAdmin($authUser);
    }

    /**
     * Determine whether the user can add integrants to the group.
     */
    public function addIntegrant(User $authUser, ChatGroup $chatGroup): bool
    {
        return $chatGroup->hasAdmin($authUser);
    }

    /**
     * Determine whether the user can change the admin flag of an integrant.
     */
    public function updateIntegrant(User $authUser, ChatGroup $chatGroup): bool
    {
        return $chatGroup->hasAdmin($authUser);
    }

    /**
     * Determine whether the user can remove integrants from the group.
     */
    public function removeIntegrant(User $authUser, ChatGroup $chatGroup): bool
    {
        return $chatGroup->hasAdmin($authUser);
    }

    /**
     * Determine whether the user can send messages to the group.
     */
    public function sendMessage(User $authUser, ChatGroup $chatGroup): bool
    {
        return $chatGroup->hasIntegrant($authUser);
    }
}
