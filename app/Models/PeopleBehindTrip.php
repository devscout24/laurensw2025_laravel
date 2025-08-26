<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleBehindTrip extends Model
{
    public function getImageAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }
}
