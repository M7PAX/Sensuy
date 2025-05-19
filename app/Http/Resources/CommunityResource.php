<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'posts_count' => $this->posts_count,
            'picture' => $this->picture,
            'background' => $this->background,
            'followers_count' => $this->followers_count,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
