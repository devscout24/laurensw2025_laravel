<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipGallery extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }
}
