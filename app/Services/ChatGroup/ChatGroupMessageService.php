<?php 

namespace App\Services\ChatGroup;

use App\Events\ChatGroupMessageSent;
use App\Http\Resources\ChatGroup\ChatGroupMessageCollection;
use App\Http\Resources\ChatGroup\ChatGroupMessageResource;
use App\Models\ChatGroup;
use App\Models\ChatGroupMessage;
use App\Models\ChatGroupMessageRead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ChatGroupMessageService
{
    public function store(array $data): ChatGroupMessageResource
    {
        $authUserId = Auth::id();
        $chatGroup = ChatGroup::findOrFail($data['id']);
        Gate::authorize('sendMessage', $chatGroup);

        $messageData = [
            'body' => $data['body'],
            'user_id' => $authUserId,
        ];

        return DB::transaction(function () use ($messageData, $chatGroup) {
            $message = $chatGroup->messages()->create($messageData);

            broadcast(new ChatGroupMessageSent($message))->toOthers();

            return new ChatGroupMessageResource($message->load('user'));
        });
    }

    public function index(array $data) 
    {
        $chatGroup = ChatGroup::findOrFail($data['id']);
        Gate::authorize('view', $chatGroup);

        $messages = $chatGroup->messages()
            ->with('user')
            ->latest()
            ->paginate($data['perPage'], ['*'], 'page', $data['page']);

        return new ChatGroupMessageCollection($messages);
    }

    public function update(array $data)
    {
        $message = ChatGroupMessage::findOrFail($data['id']);
        Gate::authorize('update', $message);

        return DB::transaction(function () use ($data, $message) {
            $message->update($data);

            return new ChatGroupMessageResource($message->refresh()->load('user'));
        });
    }

    public function delete(array $data)
    {
        $message = ChatGroupMessage::findOrFail($data['id']);
        Gate::authorize('delete', $message);

        return DB::transaction(fn () => $message->delete());
    }

    public function read(array $data): void
    {
        $authUserId = Auth::id();
        $chatGroup = ChatGroup::findOrFail($data['id']);
        Gate::authorize('view', $chatGroup);

        $unreadMessageIds = $chatGroup->messages()
            ->where(fn ($query) => $query->where('user_id', '!=', $authUserId)->orWhereNull('user_id'))
            ->whereDoesntHave('readers', fn ($query) => $query->whereKey($authUserId))
            ->pluck('id');

        $now = now();

        DB::transaction(function () use ($unreadMessageIds, $authUserId, $now) {
            $unreadMessageIds->chunk(1000)->each(fn ($messageIds) => ChatGroupMessageRead::insertOrIgnore(
                $messageIds->map(fn ($messageId) => [
                    'chat_group_message_id' => $messageId,
                    'user_id' => $authUserId,
                    'read_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])->all()
            ));
        });
    }
}
