<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ShipDecks;
use App\Traits\apiresponse;

class ShipDecksApiController extends Controller
{
    use apiresponse;

    public function index()
    {
        $data = ShipDecks::with('shipView:id,name')
            ->select('id', 'shipview_id', 'title', 'image')
            ->get();

        $data->map(function ($item) {
            $item->ship_name = $item->shipView->name ?? 'Name not defined';
            $item->image     = asset($item->image);
            $item->title     = $item->title;
            unset($item->shipView);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
}
