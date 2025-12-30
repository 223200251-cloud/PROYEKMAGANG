<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'image_url',
        'project_url',
        'technologies',
        'views',
        'likes_count',
        'comments_count',
        'is_flagged',
        'status',
        'rejection_reason',
        'visibility',
        'display_order',
        'is_highlighted',
        'highlighted_until',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'highlighted_until' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function liked($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
