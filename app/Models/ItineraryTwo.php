<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryTwo extends Model
{
    protected $fillable = ['trips_two_id', 'day', 'title', 'port', 'location', 'summary'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function tripTwo()
    {
        return $this->belongsTo(TripsTwo::class);
    }
}
