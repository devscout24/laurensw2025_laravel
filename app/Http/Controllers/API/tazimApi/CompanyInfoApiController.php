<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Traits\apiresponse;

class CompanyInfoApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = SystemSetting::select(
            'id',
            'company_name',
            'tag_line',
            'phone_code',
            'phone_number',
            'email',
            'system_short_title',

        )->get();

        $data = $data->map(function ($item) {
            return [
                'id'              => $item->id,
                'company_name'    => $item->company_name,
                'company_address' => $item->tag_line,
                'phone'           => $item->phone_code . ' ' . $item->phone_number,
                'email'           => $item->email,
                'opening_hours'   => strip_tags($item->system_short_title),
            ];
        });

        return $this->success($data, 'Success', 200);
    }
}
