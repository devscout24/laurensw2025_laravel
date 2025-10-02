<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermCondtPageMetaTag extends Model
{
protected $fillable = [
        'title',
        'description',
        'lang_id',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }
}
