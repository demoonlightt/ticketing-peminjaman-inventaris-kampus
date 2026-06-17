<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['borrow_request_id', 'inventory_id', 'quantity'])]
class BorrowRequestItem extends Model
{
    use HasFactory;

    protected $table = 'borrow_request_items';

    public $timestamps = false;

    public function borrowRequest()
    {
        return $this->belongsTo(BorrowRequest::class, 'borrow_request_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
