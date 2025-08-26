<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countrry extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
