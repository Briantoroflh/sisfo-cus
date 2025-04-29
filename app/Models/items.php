<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = 'id_items';
    protected $fillable = [
        'item_name',
        'item_image',
        'code_items',
        'id_category',
        'stock',
        'brand',
        'status',
        'item_condition'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryItems::class, 'id_category', 'id_category');
    }

    public function detailsBorrow()
    {
        return $this->hasMany(DetailsBorrow::class, 'id_items', 'id_items');
    }
}
