<?php

namespace App\Http\Resources;

use App\Models\Chat\Message;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Transform the resource into an array.
 * @mixin Message
 */
class MessageResource extends JsonResource
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
            'body' => $this->body,
            'deleted' => $this->trashed(),
            'dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at,
            ],
            'sender' => new UserResource($this->sender)
        ];
    }
}
