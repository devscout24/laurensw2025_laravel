<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }
}
