<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipView extends Model
{
    protected $fillable = [
        'name', 'description', 'build_year', 'crew_number',
        'max_guests', 'length', 'zodiac_boats', 'capacity',
        'comfort_level', 'price', 'image'
    ];

    public function cabins()
    {
        return $this->hasMany(ShipCabins::class, 'shipview_id');
    }

    public function amenities()
    {
        return $this->hasMany(ShipAmenities::class, 'shipview_id');
    }

    public function decks()
    {
        return $this->hasMany(ShipDecks::class, 'shipview_id');
    }
}
