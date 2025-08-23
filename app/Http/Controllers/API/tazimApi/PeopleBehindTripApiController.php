<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\PeopleBehindTrip;
use App\Models\PeopleBehindTripHead;
use App\Traits\apiresponse;


class PeopleBehindTripApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = PeopleBehindTrip::select(
            'id',
            'name',
            'image',
            'designation',
            'description'
        )->get();

        return $this->success($data, 'Success', 200);
    }

    public function header()
    {
        $data = PeopleBehindTripHead::select('id', 'header', 'title')->find(1);

        if (!$data) {
            return $this->error('Data not found', 404);
        }

        return $this->success($data, 'Success', 200);
    }
}
