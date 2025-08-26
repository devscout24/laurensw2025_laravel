<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayImage extends Model
{
   /*  protected $fillable = [
        'day_id',
        'image_url'
    ]; */
    protected $guarded = [];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
