<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'username' => $this->user->username,
            'is_admin' => $this->user->is_admin,
            'user_picture' => $this->user->picture,
            'content' => $this->content,
            'created_at' => $this->created_at->diffForHumans(),
            'can_update' => $request->user()?->can('update', $this->resource)?? false,
            'can_delete' => $request->user()?->can('delete', $this->resource)?? false,
        ];
    }
}
