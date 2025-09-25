<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ShipView;
use App\Traits\apiresponse;

class ShipViewApiController extends Controller
{
    use apiresponse;

    public function index()
    {
        $data = ShipView::select(
            'id',
            'name',
            'description',
            'build_year',
            'crew_number',
            'max_guests',
            'length',
            'zodiac_boats',
            'capacity',
            'comfort_level',
            'price',
            'image'
        )->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }

}
