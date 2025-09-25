<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NaturePageMetaTag extends Model
{
    public function lanuage()
    {
        return $this->hasMany(Language::class);
    }
}
