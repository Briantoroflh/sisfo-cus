<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItems extends Model
{
    use HasFactory;
    protected $table = 'category_items';
    protected $fillable = [
        'id_category',
        'category_name',
        'description'
    ];

    public function items()
    {
        return $this->hasMany(items::class, 'id_category');
    }
}
