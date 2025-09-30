<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function seoTitles()
    {
        return $this->hasMany(SeoTitle::class, 'lang_id');
    }

    public function shipPage()
    {
        return $this->hasMany(ShipPageMetaTag::class, 'lang_id');
    }
    public function aboutPage()
    {
        return $this->hasMany(AboutPageMetaTag::class, 'lang_id');
    }

    public function naturePage()
    {
        return $this->hasMany(NaturePageMetaTag::class, 'lang_id');
    }

    public function contactPage()
    {
        return $this->hasMany(ContactPageMetaTag::class, 'lang_id');
    }

    public function termConditionPage()
    {
        return $this->hasMany(TermCondtPageMetaTag::class, 'lang_id');
    }

    /* public function homePage()
    {
        return $this->belongsTo(HomePageMetaTag::class, 'language_code', 'code');
    } */
    public function homePages()
    {
        return $this->hasMany(HomePageMetaTag::class, 'lang_id');
    }
}
