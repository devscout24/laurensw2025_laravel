<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TranslateController extends Controller
{
    public function edit()
    {
        // $apiKey = TranslateApi::getValue('google_translate_key');
        return view('backend.layout.tazim.translateApi.edit');
    }

    // Update API key
    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'api_key' => 'required|string',
    //     ]);

    //     TranslateApi::setValue('google_translate_key', $request->api_key);

    //     return redirect()->back()->with('success', 'Google Translate API key updated successfully.');
    // }
    public function update(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
        ]);
        try {
            $envContent = File::get(base_path('.env'));
            $lineBreak  = "\n";
            $envContent = preg_replace([
                '/GOOGLE_TRANSLATE_KEY=(.*)\s/',
            ], [
                'GOOGLE_TRANSLATE_KEY=' . $request->api_key . $lineBreak,
            ], $envContent);

            if ($envContent !== null) {
                File::put(base_path('.env'), $envContent);
            }
            return back()->with('success', 'Updated successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update');
        }

        return redirect()->back();
    }

}
