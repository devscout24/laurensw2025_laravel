<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cruise extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function getImageUrlAttribute($value): ?string
    {
        if (!$value) return null; // if value null or empty then return null

        // if the path already starts with http, then return it
        if (str_starts_with($value, 'http')) {
            return $value;
        }
        // Check if the request is an API route, optional
        if (request()->is('api/*')) {
            return url($value);
        }

        return $value; // for web request, return original path
    }


    public function days()
    {
        return $this->hasMany(Day::class);
    }

    public function highlights()
    {
        return $this->hasMany(Highlight::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function cabins()
    {
        return $this->hasMany(CruiseCabin::class);
    }

    public function bookings()
    {
        return $this->hasMany(CruiseBooking::class);
    }
}
