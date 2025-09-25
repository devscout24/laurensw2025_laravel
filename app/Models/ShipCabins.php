<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipCabins extends Model
{
    protected $fillable = ['shipview_id', 'cabin_type', 'description', 'image'];

    public function shipView()
    {
        return $this->belongsTo(ShipView::class, 'shipview_id');
    }

    const CABIN_TYPES = [
        'oceanview'  => 'Ocean View',
        'balcony'    => 'Balcony',
        'interior'   => 'Interior',
        'royalsuite' => 'Royal Suite Class',
    ];
}
