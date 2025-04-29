<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class borrowed extends Model
{
    use HasFactory;

    protected $table = 'borroweds';
    protected $primaryKey = 'id_borrowed';
    protected $fillable = [
        'id_user',
        'date_borrowed',
        'due_date',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailsBorrow()
    {
        return $this->hasMany(DetailsBorrow::class, 'id_borrowed', 'id_borrowed');
    }
}
