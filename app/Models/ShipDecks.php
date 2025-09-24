<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipDecks extends Model
{
    protected $fillable = ['shipview_id', 'image', 'title'];

    public function shipView()
    {
        return $this->belongsTo(ShipView::class, 'shipview_id');
    }
}
