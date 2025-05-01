<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailsBorrowResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_details_borrow' => $this->id_details_borrow,
            'item' => $this->item->name ?? null,
            'amount' => $this->amount,
            'used_for' => $this->used_for,
            'status_borrow' => $this->status_borrow,
            'borrowed_by' => $this->borrowed->user->name ?? null,
            'date_borrowed' => $this->borrowed->date_borrowed,
            'due_date' => $this->borrowed->due_date,
            'return_info' => $this->detailReturn ? [
                'date_return' => $this->detailReturn->date_return
            ] : null
        ];
    }
}
