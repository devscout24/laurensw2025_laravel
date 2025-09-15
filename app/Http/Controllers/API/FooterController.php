<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use App\Traits\apiresponse;
use Exception;

class FooterController extends Controller
{
    use apiresponse;
    public function index()
    {
        try {
            $footer = SystemSetting::latest()->get();

            if ($footer->isEmpty()) {
                return $this->success([
                    'data'     => [],
                    'messages' => 'footer not found.',
                ], 'footer not found.', 200);
            }

            return $this->success([
                'data'     => $footer,
                'messages' => 'Footer retrieved successfully.',
            ], 'Footer retrieved successfully.', 200);
        } catch (Exception $e) {
            return $this->error(
                'An error occurred while retrieving footer.',
                $e->getMessage(),
                500
            );
        }
    }

    //logo retrive
    public function logoRetrive()
    {
        try {
            $systemSetting = SystemSetting::latest()->select(['logo', 'favicon'])->first();

            if (!$systemSetting || !$systemSetting->logo) {
                return $this->success([
                    'data'     => [],
                    'messages' => 'logo not found.',
                ], 'logo not found.', 200);
            }

            if (!$systemSetting->favicon) {
                return $this->success([
                    'data'     => [],
                    'messages' => 'favicon not found.',
                ], 'favicon not found.', 200);
            }

            return $this->success([
                'data'     => [
                    'logo'    => $systemSetting->logo,
                    'favicon' => $systemSetting->favicon
                ],
                'messages' => 'logo and favicon retrieved successfully.',
            ], 'logo and favicon retrieved successfully.', 200);
        } catch (Exception $e) {
            return $this->error(
                'An error occurred while retrieving logo and favicon.',
                $e->getMessage(),
                500
            );
        }
    }
}
