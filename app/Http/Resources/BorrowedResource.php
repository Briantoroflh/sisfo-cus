<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BorrowedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_borrowed' => $this->id_borrowed,
            'id_user' => new userResource($this->whenLoaded('user')),
            'id_details_borrow' => new DetailsBorrowResource($this->whenLoaded('detailsBorrow')),
            'status' => $this->status,
        ];
    }
}
