<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermCondtPageMetaTag extends Model
{
    public function lanuage()
    {
        return $this->hasMany(Language::class);
    }
}
