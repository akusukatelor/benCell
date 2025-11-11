<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'profile_photo_path' => 'string',
    ];

    // **UPDATE: Tambah default photo jika path null atau file hilang**
    public function getProfilePhotoUrlAttribute(): string
    {
        // Jika ada path dan file exists, return URL custom
        if ($this->profile_photo_path && Storage::disk('public')->exists($this->profile_photo_path)) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        // **Default: img.jpg di public/img/**
        return asset('img/img.jpg');  // Ganti path jika file-mu di tempat lain, misalnya 'images/default.jpg'
    }
}