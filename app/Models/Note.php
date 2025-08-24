<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'cruise_id',
        'type',
        'content'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }
}
