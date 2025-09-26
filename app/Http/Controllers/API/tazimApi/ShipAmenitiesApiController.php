<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ShipAmenities;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class ShipAmenitiesApiController extends Controller
{
    use apiresponse;

    public function index()
    {
        $data = ShipAmenities::with('shipView:id,name')
            ->select('id', 'shipview_id', 'amenities', 'image')
            ->get();

        $data->map(function ($item) {
            $item->ship_name  = $item->shipView->name ?? 'Name not defined';
            $item->image      = asset($item->image);
            $item->amenities  = $item->amenities;
            unset($item->shipView);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
}
