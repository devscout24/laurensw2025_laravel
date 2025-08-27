<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationTwo extends Model
{
    protected $fillable = ['trips_two_id', 'name'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    public function tripTwo()
    {
        return $this->belongsTo(TripsTwo::class);
    }
}
