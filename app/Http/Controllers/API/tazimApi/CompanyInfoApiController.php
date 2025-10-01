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
            'copyright_text',

        )->get();

        $data = $data->map(function ($item) {
            return [
                'id'              => $item->id,
                'company_name'    => $item->company_name,
                'company_address' => $item->tag_line,
                'phone'           => $item->phone_code . ' ' . $item->phone_number,
                'email'           => $item->email,
                'copyright_text'  => $item->copyright_text,
            ];
        });

        return $this->success($data, 'Success', 200);
    }
}
