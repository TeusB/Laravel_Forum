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
            'title' => $this->title,
            'content' => $this->content,
            'comments' => CommentResource::collection($this->comments),
            'comments_count' => $this->comments->count(),
            'user' => new UserResource($this->user),
            'idUser' => $this->idUser,
        ];
    }
}
