<?php

// app/Models/SocialMedia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Socialmedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'url',
        'status',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Add this line to match your actual table name
    protected $table = 'social_media';

    //for api image with url retrieve
    public function getImageAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }
}
