<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\DynamicTripButton;
use App\Traits\apiresponse;

class DynamicTripButtonApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = DynamicTripButton::select(
            'id',
            'button_name',
            'trip_url',
            'trip_id'
        )->get();

        return $this->success($data, 'Success', 200);
    }
}
