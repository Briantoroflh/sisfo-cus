<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailsBorrowResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_details_borrow' => $this->id_details_borrow,
            'id_items'          => new ItemsResource($this->whenLoaded('item')),
            'class'             => $this->class,
            'used_for'          => $this->used_for,
            'amount'            => $this->amount,
            'date_borrowed'     => $this->date_borrowed,
            'due_date'          => $this->due_date,
        ];
    }
}
