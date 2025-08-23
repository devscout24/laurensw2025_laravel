<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipGallery extends Model
{
    protected $guarded = [];

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }
}
