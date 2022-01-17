<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail->name,
            'thumbnailStorage' => $this->thumbnail->storage,
            'categories' => $this->categories,
            'public' => $this->public,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
