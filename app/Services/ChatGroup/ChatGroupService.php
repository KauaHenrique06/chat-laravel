<?php 

namespace App\Services\ChatGroup;

use App\Http\Resources\ChatGroup\ChatGroupCollection;
use App\Http\Resources\ChatGroup\ChatGroupResource;
use App\Models\ChatGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ChatGroupService
{
    public function store(array $data): ChatGroupResource
    {
        $authUserId = Auth::id();

        return DB::transaction(function () use ($data, $authUserId) {
            $chatGroup = ChatGroup::create($data);

            $chatGroup->integrants()->attach($authUserId, ['is_admin' => true]);

            return new ChatGroupResource($chatGroup->load('integrants'));
        }); 
    }

    public function update(array $data)
    {
        $chatGroup = ChatGroup::findOrFail($data['id']);
        return DB::transaction(function () use ($data, $chatGroup) {
            $chatGroup->update($data);

            return new ChatGroupResource($chatGroup->refresh()->load('integrants'));
        });
    }

    public function index(array $data): ChatGroupCollection
    {
        $chatGroups = Auth::user()->chatGroups()
            ->with('integrants')
            ->paginate($data['perPage'], ['*'], 'page', $data['page']);

        return new ChatGroupCollection($chatGroups);
    }

    public function show(array $data): ChatGroupResource
    {
        $chatGroup = ChatGroup::with('integrants')->findOrFail($data['id']);
        Gate::authorize('view', $chatGroup);

        return new ChatGroupResource($chatGroup);
    }

    public function delete(array $data)
    {
        $chatGroup = ChatGroup::findOrFail($data['id']);
        Gate::authorize('delete', $chatGroup);

        return DB::transaction(function () use ($chatGroup) {
            $chatGroup->delete();
        });
    }
}