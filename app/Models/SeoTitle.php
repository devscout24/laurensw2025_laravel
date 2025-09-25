<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoTitle extends Model
{
    protected $fillable = [
        'title',
        'description',
        'language_code'
    ];
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }
}
