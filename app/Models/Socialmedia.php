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

    public function getImageUrlAttribute($value): ?string
    {
        if (!$value) return null; // if value null or empty then return null

        // if the path already starts with http, then return it
        if (str_starts_with($value, 'http')) {
            return $value;
        }
        // Check if the request is an API route, optional
        if (request()->is('api/*')) {
            return url($value);
        }

        return $value; // for web request, return original path
    }
}
