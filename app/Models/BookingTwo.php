<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTwo extends Model
{
    use HasFactory;

    protected $guarded = [];



    // A booking belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A booking belongs to a trip
    public function tripTwo()
    {
        return $this->belongsTo(TripsTwo::class, 'trips_two_id');
    }

    // A booking belongs to a cabinTwo (optional)
    public function cabinTwo()
    {
        return $this->belongsTo(CabinTwo::class, 'cabin_two_id');
    }
}
