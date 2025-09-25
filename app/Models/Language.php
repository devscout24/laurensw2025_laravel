<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public function seoTitle()
    {
        return $this->belongsTo(SeoTitle::class);
    }
    
    public function shipPage()
    {
        return $this->belongsTo(ShipPageMetaTag::class);
    }
    public function aboutPage()
    {
        return $this->belongsTo(AboutPageMetaTag::class);
    }
    
    public function naturePage()
    {
        return $this->belongsTo(NaturePageMetaTag::class);
    }
    
    public function contactPage()
    {
        return $this->belongsTo(ContactPageMetaTag::class);
    }
    
    public function termConditionPage()
    {
        return $this->belongsTo(TermCondtPageMetaTag::class);
    }
    
    public function homePage()
    {
        return $this->belongsTo(HomePageMetaTag::class);
    }
}
