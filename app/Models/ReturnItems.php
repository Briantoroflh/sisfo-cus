<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItems extends Model
{
    use HasFactory;

    protected $table = 'return_items';
    protected $fillable = [
        'id_return',
        'id_borrow',
        'date_return'
    ];

    public function borrow()
    {
        return $this->belongsTo(Borrowed::class, 'id_borrow');
    }

    public function details()
    {
        return $this->hasMany(DetailReturns::class, 'id_borrowed', 'id_borrow');
    }
}
