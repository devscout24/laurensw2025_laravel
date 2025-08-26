<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabin extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // A cabin belongs to a trip
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    // A cabin has many prices
    public function prices()
    {
        return $this->hasMany(CabinPrice::class);
    }
}
