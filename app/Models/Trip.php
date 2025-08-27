<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // Trip.php
    public function ship()
    {
        return $this->hasOne(Ship::class);
    }
    public function cabins()
    {
        return $this->hasMany(Cabin::class);
    }
    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }
    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }
    public function locations()
    {
        return $this->hasMany(Location::class);
    }
    public function countrries()
    {
        return $this->hasMany(Countrry::class);
    }
    public function gallery()
    {
        return $this->hasMany(TripGallery::class);
    }
}
