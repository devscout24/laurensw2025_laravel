<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPageMetaTag extends Model
{
    protected $fillable = [
        'title',
        'description',
        'language_code',
    ];
    public function lanuage()
    {
        return $this->hasMany(Language::class, 'language_code', 'code');
    }
}
