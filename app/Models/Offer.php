<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'cruise_id',
        'description'
    ];

    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }
}
