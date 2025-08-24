<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    protected $fillable = [
        'cruise_id',
        'highlight'
    ];

    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }
}
