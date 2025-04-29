<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailsBorrowResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_details_borrow' => $this->id_details_borrow,
            'id_items' => $this->id_items,
            'id_borrowed' => $this->id_borrowed,
            'status_borrow' => $this->status_borrow,
            'used_for' => $this->used_for,
            'amount' => $this->amount,
            'item' => new ItemsResource($this->whenLoaded('item')),
            'borrowed' => new BorrowedResource($this->whenLoaded('borrowed')),
            'detail_return' => new DetailReturnsResource($this->whenLoaded('detailReturn')),
        ];
    }
}
