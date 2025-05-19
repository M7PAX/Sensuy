<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'files' => FileResource::collection($this->whenLoaded('files')),
            'username' => $this->user->username,
            'is_admin' => $this->user->is_admin,
            'user_picture' => $this->user->picture,
            'community_slug' => $this->community->slug,
            'community_name' => $this->community->name,
            'community_picture' => $this->community->picture,
            'slug' => $this->slug,
            'votes' => $this->votes,
            'voted' => $this->whenLoaded('voted'),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'comments_count' => $this->comments_count,
            'created_at_hum' => $this->created_at->diffForHumans(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
