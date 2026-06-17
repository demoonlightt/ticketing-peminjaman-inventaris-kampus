<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'student_id',
    'approved_by',
    'request_date',
    'borrow_date',
    'return_date',
    'purpose',
    'attachment',
    'status'
])]
class BorrowRequest extends Model
{
    use HasFactory;

    protected $table = 'borrow_requests';

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items()
    {
        return $this->hasMany(BorrowRequestItem::class, 'borrow_request_id');
    }

    public function handover()
    {
        return $this->hasOne(Handover::class, 'borrow_request_id');
    }

    public function returnRecord()
    {
        return $this->hasOne(ReturnRecord::class, 'borrow_request_id');
    }
}
