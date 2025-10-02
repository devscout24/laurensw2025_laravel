<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoTitle extends Model
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
