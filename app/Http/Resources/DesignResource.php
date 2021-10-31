<?php

namespace App\Http\Resources;

use App\Models\Design;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin Design
 */
class DesignResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'title' => $this->title,
            'slug' => $this->slug,
            'images' => $this->images,
            'is_live' => $this->is_live,
            'likes_count' => $this->likes()->count(),
            'description' => $this->description,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'tag_list' => [
                'tags' => $this->tag_array,
                'normalized' => $this->tag_array_normalized
            ],
            'team' => $this->team ? [
                'name' => $this->team->name,
                'slug' => $this->team->slug
            ] : null,
            'created_at_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at,
            ],
            'updated_at_dates' => [
                'updated_at_human' => $this->updated_at->diffForHumans(),
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
