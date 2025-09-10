<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    //for api image with url retrieve
    public function getImageAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }



}
