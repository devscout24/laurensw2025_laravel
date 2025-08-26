<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripsTwo extends Model
{
    protected $fillable = [
        'region',
        'url',
        'external_id',
        'code',
        'combination',
        'only_in_combination',
        'translated',
        'departure_date',
        'return_date',
        'name',
        'summary',
        'embark',
        'disembark',
        'dr_usp',
        'trip_included',
        'trip_excluded',
        'days',
        'nights',
        'ship_id',
        'ship_name',
        'map'
    ];

    public function cabinsTwos()
    {
        return $this->hasMany(CabinTwo::class, 'trips_two_id');
    }

    public function extras()
    {
        return $this->hasMany(Extra::class, 'trips_two_id');
    }

    public function destinationsTwos()
    {
        return $this->hasMany(DestinationTwo::class, 'trips_two_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'trips_two_id');
    }

    public function itinerariesTwos()
    {
        return $this->hasMany(ItineraryTwo::class, 'trips_two_id');
    }
}
