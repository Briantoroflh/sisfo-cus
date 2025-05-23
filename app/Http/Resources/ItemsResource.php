<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_items' => $this->id_items,
            'item_name' => $this->item_name,
            'item_image' =>  $this->item_image ? asset('storage/' . $this->item_image) : null,
            'code_items' => $this->code_items,
            'id_category' => new CategoryItemsResource($this->whenLoaded('category')),
            'stock' => $this->stock,
            'brand' => $this->brand,
            'status' => $this->status,
            'item_condition' => $this->item_condition,
            'details_borrow' => DetailsBorrowResource::collection($this->whenLoaded('detailsBorrow'))
        ];
    }
}
