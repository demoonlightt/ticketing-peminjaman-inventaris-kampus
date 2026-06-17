<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'category_id',
    'code',
    'name',
    'description',
    'total_stock',
    'available_stock',
    'location',
    'image',
    'condition'
])]
class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function borrowRequestItems()
    {
        return $this->hasMany(BorrowRequestItem::class, 'inventory_id');
    }
}
