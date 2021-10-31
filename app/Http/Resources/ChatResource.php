<?php

namespace App\Http\Resources;

use App\Models\Chat\Chat;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * Transform the resource into an array.
 * @mixin Chat
 */
class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at,
            ],
            'is_unread' => $this->isUnreadForUser(Auth::id()),
            'latest_message' => new MessageResource($this->latest_message),
            'participants' => UserResource::collection($this->participants)
        ];
    }
}
