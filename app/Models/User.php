<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'status', 'google_id', 'provider', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOfficer(): bool
    {
        return $this->role === 'officer';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Get the URL for the user's avatar.
     */
    public function getAvatarUrl(): ?string
    {
        if ($this->avatar) {
            return \Illuminate\Support\Str::startsWith($this->avatar, 'http')
                ? $this->avatar
                : asset('storage/' . $this->avatar);
        }
        return null;
    }

    /**
     * Get name initials (max 2 characters).
     */
    public function getInitials(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
            if (strlen($initials) >= 2) {
                break;
            }
        }
        return $initials ?: 'U';
    }

    // Relationships
    public function mahasiswaProfile()
    {
        return $this->hasOne(MahasiswaProfile::class, 'user_id');
    }

    public function officerProfile()
    {
        return $this->hasOne(OfficerProfile::class, 'user_id');
    }

    public function borrowRequests()
    {
        return $this->hasMany(BorrowRequest::class, 'student_id');
    }

    public function approvedRequests()
    {
        return $this->hasMany(BorrowRequest::class, 'approved_by');
    }

    public function handovers()
    {
        return $this->hasMany(Handover::class, 'officer_id');
    }

    public function returns()
    {
        return $this->hasMany(ReturnRecord::class, 'officer_id');
    }
}
