<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsBorrow extends Model
{
    use HasFactory;

    protected $table = 'details_borrows';
    protected $primaryKey = 'id_details_borrow';
    protected $fillable = [
        'id_items',
        'id_borrowed',
        'status_borrow',
        'used_for',
        'amount'
    ];

    public function borrowed()
    {
        return $this->belongsTo(Borrowed::class, 'id_borrowed', 'id_borrowed');
    }

    public function item()
    {
        return $this->belongsTo(Items::class, 'id_items', 'id_items');
    }

    public function detailReturn()
    {
        return $this->hasOne(DetailReturns::class, 'id_details_borrow', 'id_details_borrow');
    }
}
