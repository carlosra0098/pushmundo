<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    /**
     * Profile URL used by AdminLTE user menu.
     *
     * @return string
     */
    public function adminlte_profile_url()
    {
        return 'profile';
    }

    /**
     * Profile image used by AdminLTE (uploaded avatar or Gravatar fallback).
     *
     * @return string
     */
    public function adminlte_image()
    {
        if (! empty($this->avatar)) {
            // Use public disk path
            return Storage::disk('public')->url($this->avatar);
        }

        $email = strtolower(trim($this->email ?? ''));
        $hash = md5($email);
        return "https://www.gravatar.com/avatar/{$hash}?s=128&d=identicon";
    }

    /**
     * Short description shown in user menu (optional).
     *
     * @return string
     */
    public function adminlte_desc()
    {
        return $this->email ?? '';
    }
}
