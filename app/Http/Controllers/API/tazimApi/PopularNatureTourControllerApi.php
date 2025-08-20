<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\PopularNatureTour;
use Illuminate\Http\Request;
use App\Traits\apiresponse;

class PopularNatureTourControllerApi extends Controller
{
    use apiresponse;

    public function index()
    {
        $data = PopularNatureTour::select('id', 'header', 'title')->find(1);

        if (!$data) {
            return $this->error('Data not found', 404);
        }

        return $this->success($data, 'Success', 200);
    }
}
