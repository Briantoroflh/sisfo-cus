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
        'id_details_borrow',
        'date_return'
    ];

    public function detailsBorrow()
    {
        return $this->belongsTo(DetailsBorrow::class, 'id_details_borrow', 'id_details_borrow');
    }
}
