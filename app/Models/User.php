<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'role',
        'user_type',
        'is_banned',
        'username',
        'bio',
        'profile_picture',
        'avatar_url',
        'location',
        'website',
        'phone',
        'company_name',
        'company_website',
        'company_description',
        'company_phone',
        'portfolios_count',
        'followers_count',
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

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isCreator()
    {
        return $this->user_type === 'individual';
    }

    public function isCompany()
    {
        return $this->user_type === 'company';
    }

    public function savedCreators()
    {
        return $this->hasMany(SavedCreator::class, 'company_id');
    }

    public function isSavedBy($companyId)
    {
        return SavedCreator::where('company_id', $companyId)
            ->where('creator_id', $this->id)
            ->exists();
    }
}
