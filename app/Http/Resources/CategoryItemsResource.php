<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryItemsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_category' => $this->id_category,
            'category_name' => $this->category_name,
            'items' => ItemsResource::collection($this->whenLoaded('items')),
        ];
    }
}
