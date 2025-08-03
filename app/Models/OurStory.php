<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurStory extends Model
{
    protected $table = 'our_stories';

    protected $fillable = [
        'header',
        'title',
        'description',
        'image',
    ];
}
