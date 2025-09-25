<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoTitle extends Model
{
   public function lanuage()
    {
        return $this->hasMany(Language::class);
    }
}
