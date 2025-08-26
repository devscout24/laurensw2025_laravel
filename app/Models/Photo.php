<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['trips_two_id', 'url'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function trip()
    {
        return $this->belongsTo(TripsTwo::class);
    }
}
