<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
        'capacity',
        'description',
        'status',
        'user_id' // to track who created the venue
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 