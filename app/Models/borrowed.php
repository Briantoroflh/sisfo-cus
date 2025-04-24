<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class borrowed extends Model
{
    use HasFactory;

    protected $table = 'borroweds';
    protected $fillable = [
        'id_borrowed',
        'id_user',
        'used_for',
        'date_borrowed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function details()
    {
        return $this->hasMany(DetailsBorrow::class, 'id_borrowed');
    }

    public function return()
    {
        return $this->hasOne(ReturnItems::class, 'id_borrow');
    }
}
