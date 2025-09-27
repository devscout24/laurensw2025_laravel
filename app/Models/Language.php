<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public function seoTitles()
    {
        return $this->hasMany(SeoTitle::class, 'language_code', 'code');
    }

    public function shipPage()
    {
        return $this->belongsTo(ShipPageMetaTag::class, 'language_code', 'code');
    }
    public function aboutPage()
    {
        return $this->belongsTo(AboutPageMetaTag::class, 'language_code', 'code');
    }

    public function naturePage()
    {
        return $this->belongsTo(NaturePageMetaTag::class, 'language_code', 'code');
    }

    public function contactPage()
    {
        return $this->belongsTo(ContactPageMetaTag::class, 'language_code', 'code');
    }

    public function termConditionPage()
    {
        return $this->belongsTo(TermCondtPageMetaTag::class, 'language_code', 'code');
    }

    public function homePage()
    {
        return $this->belongsTo(HomePageMetaTag::class, 'language_code', 'code');
    }
}
