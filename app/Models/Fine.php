<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['return_id', 'amount', 'reason', 'paid_status'])]
class Fine extends Model
{
    use HasFactory;

    protected $table = 'fines';

    public $timestamps = false;

    public function returnRecord()
    {
        return $this->belongsTo(ReturnRecord::class, 'return_id');
    }
}
