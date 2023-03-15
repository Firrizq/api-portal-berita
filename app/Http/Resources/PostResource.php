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
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'writer'=> $this->whenLoaded('writer'),
            'news_content' => $this->news_content,
            // 'created_at' => $this->created_at,
            'created_at' => date_format($this->created_at, "y/m/d H:i:s"),
        ];
    }
}
