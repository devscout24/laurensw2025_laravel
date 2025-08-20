<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class FAQControllerApi extends Controller
{
    use apiresponse;
    public function index()
    {
        $faqs = FAQ::select(
            'id',
            'que',
            'ans',
            'status'
        )->get();
        return $this->success($faqs, 'Success', 200);
    }
}
