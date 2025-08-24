<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cruise extends Model
{
/*     protected $fillable = [
        'external_id',
        'name',
        'length',
        'ship_name',
        'destination',
        'embarcation',
        'disembarkation',
        'start_date',
        'end_date',
        'url',
        'map_route',
        'prices'
    ]; */

    protected $guarded = [];

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
}
