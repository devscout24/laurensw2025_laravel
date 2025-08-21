<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countrry extends Model
{
    protected $guarded = [];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
