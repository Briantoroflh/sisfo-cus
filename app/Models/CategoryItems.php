<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItems extends Model
{
    use HasFactory;
    protected $table = 'category_items';
    protected $primaryKey = 'id_category';
    protected $fillable = [
        'category_name'
    ];

    public function items()
    {
        return $this->hasMany(Items::class, 'id_category', 'id_category');
    }
}
