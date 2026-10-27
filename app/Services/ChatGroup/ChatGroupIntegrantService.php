<?php 

namespace App\Services\ChatGroup;

use App\Exceptions\ApiException;
use App\Http\Resources\ChatGroup\ChatGroupResource;
use App\Models\ChatGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ChatGroupIntegrantService
{
    public function store(array $data): ChatGroupResource
    {
        $chatGroup = ChatGroup::findOrFail($data['id']);
        Gate::authorize('addIntegrant', $chatGroup);

        return DB::transaction(function () use ($data, $chatGroup) {
            $chatGroup->integrants()->syncWithoutDetaching($data['users']);

            return new ChatGroupResource($chatGroup->load('integrants'));
        });
    }

    public function update(array $data): ChatGroupResource
    {
        $chatGroup = ChatGroup::findOrFail($data['id']);
        Gate::authorize('updateIntegrant', $chatGroup);

        if (!$data['is_admin'])
        {
            $this->ensureRemainingAdmin($chatGroup, [$data['user_id']]);
        }

        return DB::transaction(function () use ($data, $chatGroup) {
            $chatGroup->integrants()->updateExistingPivot($data['user_id'], [
                'is_admin' => $data['is_admin']
            ]);

            return new ChatGroupResource($chatGroup->load('integrants'));
        });
    }

    public function delete(array $data): ChatGroupResource
    {
        $chatGroup = ChatGroup::findOrFail($data['id']);
        Gate::authorize('removeIntegrant', $chatGroup);

        $this->ensureRemainingAdmin($chatGroup, $data['users']);

        return DB::transaction(function () use ($data, $chatGroup) {
            $chatGroup->integrants()->detach($data['users']);

            return new ChatGroupResource($chatGroup->load('integrants'));
        });
    }

    private function ensureRemainingAdmin(ChatGroup $chatGroup, array $userIds): void
    {
        $hasRemainingAdmin = $chatGroup->integrants()
            ->wherePivot('is_admin', true)
            ->whereKeyNot($userIds)
            ->exists();

        if (!$hasRemainingAdmin)
        {
            throw new ApiException('Cannot remove the last admin!', 422);
        }
    }
}
