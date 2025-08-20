<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\PeopleBehindTrip;
use App\Traits\apiresponse;


class PeopleBehindTripApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = PeopleBehindTrip::select(
            'id',
            'button_name',
            'trip_url',
            'trip_id'
        )->get();

        return $this->success($data, 'Success', 200);
    }
}
