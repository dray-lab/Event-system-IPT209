<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'features',
        'event_id',
        'user_id',
        'status',
        'max_tickets',
        'available_tickets'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'max_tickets' => 'integer',
        'available_tickets' => 'integer'
    ];

    // Relationship with Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relationship with User (Package Creator)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
