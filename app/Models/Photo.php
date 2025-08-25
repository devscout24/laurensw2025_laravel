<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['trips_two_id', 'url'];

    public function trip()
    {
        return $this->belongsTo(TripsTwo::class);
    }
}
