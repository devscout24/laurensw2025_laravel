<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CabinTwo extends Model
{
    protected $fillable = [
        'trips_two_id',
        'cabin_id',
        'title',
        'price',
        'old_price',
        'discount',
        'cab_units',
        'ber_units',
        'male_units',
        'female_units'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function tripTwo()
    {
        return $this->belongsTo(TripsTwo::class);
    }

     // One cabin can have many bookings
    public function bookingsTwo()
    {
        return $this->hasMany(BookingTwo::class, 'cabin_two_id');
    }
}
