<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ShipCabins;
use App\Traits\apiresponse;

class ShipCabinsApiController extends Controller
{
    use apiresponse;

    public function index()
    {
        $data = ShipCabins::with('shipView:id,name') // eager load only id & name from ship_views
            ->select('id', 'shipview_id', 'cabin_type', 'description', 'image')
            ->get();

        $data->map(function ($item) {
            $item->ship_name  = $item->shipView->name ?? 'Name not defined';
            $item->cabin_type = ShipCabins::CABIN_TYPES[$item->cabin_type] ?? $item->cabin_type;
            $item->image      = asset($item->image);
            unset($item->shipView); // optional: remove relation object if you don’t want it
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
}
