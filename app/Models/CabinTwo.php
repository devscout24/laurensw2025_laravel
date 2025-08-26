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

    public function tripTwo()
    {
        return $this->belongsTo(TripsTwo::class);
    }
}
