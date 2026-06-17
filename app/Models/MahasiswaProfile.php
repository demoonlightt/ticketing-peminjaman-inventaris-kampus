<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'nim', 'prodi', 'fakultas', 'angkatan'])]
class MahasiswaProfile extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_profiles';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
