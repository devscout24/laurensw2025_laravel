<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipAmenities extends Model
{
    protected $fillable = ['shipview_id', 'image', 'amenities'];

    public function shipView()
    {
        return $this->belongsTo(ShipView::class, 'shipview_id');
    }
}
