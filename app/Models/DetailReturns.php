<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReturns extends Model
{
    use HasFactory;

    protected $table = 'detail_returns';
    protected $primaryKey = 'id_detail_return';
    protected $fillable = [
        'id_borrowed',
        'status',
        'soft_delete',
        'date_return',
    ];

    public function borrowed()
    {
        return $this->belongsTo(Borrowed::class, 'id_borrowed', 'id_borrowed');
    }
}
