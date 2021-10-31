<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


/**
 * Transform the resource into an array.
 * @mixin User
 */
class UserResource extends JsonResource
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
            'username' => $this->username,
            $this->mergeWhen(Auth::id() == $this->id, [
                'email' => $this->email,
            ]),
            'name' => $this->name,
            'designs' => DesignResource::collection($this->whenLoaded('designs')),
            'create_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ],
            'formatted_address' => $this->formatted_address,
            'tagline' => $this->tagline,
            'location' => $this->location,
            'available_to_hire' => $this->available_to_hire
        ];
    }
}
