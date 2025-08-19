<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ResponsibleTravel;
use App\Traits\apiresponse;

class ResponsibleTravelApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = ResponsibleTravel::latest()->get();

        $data = $data->map(function ($item) {
            return [
                'id'            => $item->id,
                'heading'       => $item->heading,
                'description'   => $item->description,
                'image'         => asset($item->image),
            ];
        });

        return $this->success($data, 'Fetch Successfull', 200);
    }
}
