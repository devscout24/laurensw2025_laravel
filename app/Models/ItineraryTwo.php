<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryTwo extends Model
{
    protected $fillable = ['trips_two_id', 'day', 'title', 'port', 'location', 'summary'];

    public function tripTwo()
    {
        return $this->belongsTo(TripsTwo::class);
    }
}
