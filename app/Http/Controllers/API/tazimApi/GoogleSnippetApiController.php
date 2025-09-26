<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\GoogleSnippet;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class GoogleSnippetApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = GoogleSnippet::where('status', 'active')->select(
            'id',
            'title',
            'slug',
            'snippet_content'
        )->get();
        return $this->success($data, 'Success', 200);
    }
}
