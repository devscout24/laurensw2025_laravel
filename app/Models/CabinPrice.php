<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CabinPrice extends Model
{
    protected $guarded = [];

    // A price belongs to a cabin
    public function cabin()
    {
        return $this->belongsTo(Cabin::class);
    }
}
