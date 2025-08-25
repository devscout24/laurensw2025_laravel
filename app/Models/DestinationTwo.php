<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationTwo extends Model
{
    protected $fillable = ['trips_two_id', 'name'];

    public function tripTwo()
    {
        return $this->belongsTo(TripsTwo::class);
    }
}
