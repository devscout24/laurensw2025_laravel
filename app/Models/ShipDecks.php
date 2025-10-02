<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipDecks extends Model
{
    protected $fillable = ['shipview_id', 'image', 'title'];
    protected $hidden   = ['created_at', 'updated_at'];

    public function shipView()
    {
        return $this->belongsTo(ShipView::class, 'shipview_id');
    }
}
