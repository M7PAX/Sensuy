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
            'user_picture' => $this->user->picture,
            'community' => $this->community->slug,
            'community_slug' => $this->community->slug, // WHY
            'community_picture' => $this->community->picture,
            'slug' => $this->slug,
            'votes' => $this->votes,
            'voted' => $this->whenLoaded('voted'),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'comments_count' => $this->comments_count,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
