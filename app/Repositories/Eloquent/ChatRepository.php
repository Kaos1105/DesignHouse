<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat\Chat;
use App\Models\User;
use App\Repositories\Contracts\IChat;

class ChatRepository extends BaseRepository implements IChat
{
    public function __construct(Chat $model)
    {
        parent::__construct($model);
    }

    public function createParticipants(string $chatId, array $data)
    {
        $chat = Chat::find($chatId);
        $chat->participants()->sync($data);
    }

    public function getUserChats(string $userId): \Illuminate\Database\Eloquent\Collection
    {
        $user = User::find($userId);
        return $user->chats()->with(['messages', 'participants'])->get();
    }
}