<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'body'       => $this->body,
            'image'      => $this->image ? asset('storage/' . $this->image) : null,
            'created_at' => $this->created_at->toDateTimeString(),
            'user'       => new UserResource($this->whenLoaded('user')),
        ];
    }
}
