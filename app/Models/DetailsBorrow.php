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
        'amount',
        'used_for',
        'class',
        'date_borrowed',
        'due_date',
    ];

    public function item()
    {
        return $this->belongsTo(items::class, 'id_items');
    }

    // Relasi ke borroweds
    public function borrowed()
    {
        return $this->hasOne(Borrowed::class, 'id_details_borrow');
    }
}
