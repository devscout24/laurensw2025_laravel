<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Traits\apiresponse;

class SettingsApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = SystemSetting::find(1)->select(
            'id',
            'company_name',
            'phone_code',
            'phone_number',
            'email',
        )->get();

        return $this->success($data, 'Success', 200);
    }
}
