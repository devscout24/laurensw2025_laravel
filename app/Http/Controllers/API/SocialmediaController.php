<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Socialmedia;
use App\Traits\apiresponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class SocialmediaController extends Controller
{
    use apiresponse;

    /**
     * Retrieves all social media information.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index()
    {
        try {
            $socialMedia = Socialmedia::latest()->get();

            if ($socialMedia->isEmpty()) {
                return $this->success([
                    'data'     => [],
                    'messages' => 'social media not found.',
                ], 'social media not found.', 200);
            }

            return $this->success([
                'data'     => $socialMedia,
                'messages' => 'Social media retrieved successfully.',
            ], 'Social media retrieved successfully.', 200);
        } catch (Exception $e) {
            return $this->error(
                'An error occurred while retrieving social media.',
                $e->getMessage()
            );
        }
    }
}
