<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BorrowedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_borrowed' => $this->id_borrowed,
            'id_user' => $this->id_user,
            'user_name' => $this->user->name ?? null,
            'date_borrowed' => $this->date_borrowed,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'details_borrow' => DetailsBorrowResource::collection($this->detailsBorrow)
        ];
    }
}
