<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedCreator extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'creator_id',
        'notes',
    ];

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
