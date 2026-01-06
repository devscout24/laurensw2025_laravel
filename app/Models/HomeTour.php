<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeTour extends Model
{
    protected $fillable = [
        'label',
        'header',
        'title',
        'duration',
        'ship',
        'price',
        'image',
        'alt_tag',
        'trip_id',
    ];
    protected $appends = ['trip_type'];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    // ⭐ Custom attribute accessor
    public function getTripTypeAttribute()
    {
        return 'trip_one';
    }
}
