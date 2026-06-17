<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'borrow_request_id',
    'officer_id',
    'return_date',
    'item_condition',
    'late_days',
    'notes'
])]
class ReturnRecord extends Model
{
    use HasFactory;

    protected $table = 'returns';

    public $timestamps = false;

    public function borrowRequest()
    {
        return $this->belongsTo(BorrowRequest::class, 'borrow_request_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function fine()
    {
        return $this->hasOne(Fine::class, 'return_id');
    }
}
