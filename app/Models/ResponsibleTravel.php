<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsibleTravel extends Model
{
    protected $table = 'responsible_travel';

    protected $fillable = [
        'heading',
        'image',
        'description',
    ];
}
