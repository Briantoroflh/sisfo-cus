<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailsReturnsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_detail_return' => $this->id_detail_return,
            'user_name' => $this->borrowed->user->name,
            'user_email' => $this->borrowed->user->email,
            'date_return' => $this->date_return,
            'status' => $this->status,
        ];
    }
}
