<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    protected $guarded = [];

    // Ship belongs to a Trip
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
    // Ship.php
    public function specs()
    {
        return $this->hasMany(ShipSpec::class);
    }
    public function gallery()
    {
        return $this->hasMany(ShipGallery::class);
    }
}
