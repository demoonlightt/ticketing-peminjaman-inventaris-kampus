<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['borrow_request_id', 'officer_id', 'handover_date', 'notes'])]
class Handover extends Model
{
    use HasFactory;

    protected $table = 'handovers';

    public $timestamps = false;

    public function borrowRequest()
    {
        return $this->belongsTo(BorrowRequest::class, 'borrow_request_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}
