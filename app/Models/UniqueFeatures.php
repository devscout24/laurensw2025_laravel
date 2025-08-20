<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniqueFeatures extends Model
{
    protected $table = 'unique_features';

    protected $fillable = [
        'heading',
        'description',
        'image',
    ];
}
