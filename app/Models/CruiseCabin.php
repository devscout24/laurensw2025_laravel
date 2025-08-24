<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CruiseCabin extends Model
{
   protected $guarded = [];

    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }
}
