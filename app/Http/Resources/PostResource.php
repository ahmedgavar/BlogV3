<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            // 'Post_title' => $this->title,
            // 'post_content' => $this->content,
            // 'time_of_creation' => $this->created_at,
            // 'time_of_update' => $this->updated_at,
            // 'user_id' => $this->user_id,
            $this->load(['comments', 'images']),

        ];
    }
}
