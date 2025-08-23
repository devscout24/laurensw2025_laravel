<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\TravelAdvisor;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class TravelAdvisorControllerApi extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = TravelAdvisor::select(
            'id',
            'name',
            'designation',
            'experience',
            'trip_success',
            'whatsapp',
            'image',
        )->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });
        return $this->success($data, 'Success', 200);
    }
}
