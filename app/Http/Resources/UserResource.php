<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'bio'        => $this->bio,
            'image'      => $this->image ? asset('storage/' . $this->image) : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
