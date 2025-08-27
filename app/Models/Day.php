<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }

    public function images()
    {
        return $this->hasMany(DayImage::class);
    }
}
