<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CruiseCabin extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }

    // Cabin relationship with Cruise Booking model
    public function bookings()
    {
        return $this->hasMany(CruiseBooking::class, 'cruise_cabin_id');
    }
}
