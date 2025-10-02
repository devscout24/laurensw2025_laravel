<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\TravelAdvisor;
use App\Traits\apiresponse;

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
            'alt_tag'
        )
            ->latest() // order by created_at desc
            ->first(); // fetch only the newest one

        if ($data) {
            $data->image = asset($data->image);
        }

        return $this->success($data, 'Success', 200);
    }

}
