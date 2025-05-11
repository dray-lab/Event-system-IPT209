<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'venue_id',
        'user_id',
        'status',
        'ticket_price',
        'capacity',
        'event_type'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'ticket_price' => 'decimal:2'
    ];

    // Relationship with Venue
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    // Relationship with User (Event Organizer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
