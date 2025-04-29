<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailReturnsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_detail_return' => $this->id_detail_return,
            'id_details_borrow' => $this->id_details_borrow,
            'date_return' => $this->date_return,
            'details_borrow' => new DetailsBorrowResource($this->whenLoaded('detailsBorrow')),
        ];
    }
}
