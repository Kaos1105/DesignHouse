<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Http\Resources\MessageResource;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Repositories\Contracts\IChat;
use App\Repositories\Contracts\IMessage;
use App\Repositories\Eloquent\Criterion\WithTrashed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // send message to user
    protected IMessage $messageRepo;
    protected IChat $chatRepo;

    public function __construct(IChat $chatRepo, IMessage $messageRepo)
    {
        $this->chatRepo = $chatRepo;
        $this->messageRepo = $messageRepo;
    }

    public function sendMessage(Request $request)
    {
        // validate request
        $data = $request->validate([
            'recipient' => ['required'],
            'body' => ['required']
        ]);

        $recipient = $data['recipient'];
        $body = $data['body'];
        $user = Auth::user();

        // prevent send to message to yourself

        if ($recipient == $user->id) {
            return response()->json([
                'message' => 'You cannot send message to yourself'
            ]);
        }
        // check if there is an existing char between the auth user and the recipient
        $chat = $user->getChatWithUser($recipient);

        if (!$chat) {
            $chat = $this->chatRepo->create([]);
            $this->chatRepo->createParticipants($chat->id, [$user->id, $recipient]);
        }

        // add the message to the chat
        $message = $this->messageRepo->create([
            'user_id' => $user->id,
            'chat_id' => $chat->id,
            'body' => $body,
        ]);

        return new MessageResource($message);
    }

    //get chat for user
    public function getUserChats(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $chats = $this->chatRepo->getUserChats(Auth::id());
        return ChatResource::collection($chats);
    }

    // get messages for chat
    public function getChatMessages(string $chatId): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $messages = $this->messageRepo->withCriteria([new WithTrashed()])->findWhere('chat_id', $chatId);
        return MessageResource::collection($messages);
    }

    // mark chat as read
    public function markAsRead(Chat $chat): \Illuminate\Http\JsonResponse
    {
        $chat->markAsReadForUser(Auth::id());
        return response()->json(['message' => 'successful']);
    }

    // destroy message
    public function destroyMessage(Message $message)
    {
        $this->authorize('delete', $message);
        $message->delete();
    }
}
