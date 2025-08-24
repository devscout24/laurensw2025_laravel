<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    //  protected $fillable = ['cruise_id','title','text'];
    protected $guarded = [];

    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }

    public function images()
    {
        return $this->hasMany(DayImage::class);
    }
}
