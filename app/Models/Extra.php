<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    protected $fillable = ['trips_two_id', 'name', 'availability', 'price'];

    public function tripTwo()
    {
        return $this->belongsTo(TripsTwo::class);
    }
}
