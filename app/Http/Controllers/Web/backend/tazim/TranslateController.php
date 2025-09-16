<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\TranslateApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TranslateController extends Controller
{
    public function edit()
    {
        $apiKey = TranslateApi::getValue('google_translate_key');
        return view('backend.layout.tazim.translateApi.edit', compact('apiKey'));
    }

    // Update API key
    public function update(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
        ]);

        TranslateApi::setValue('google_translate_key', $request->api_key);

        return redirect()->back()->with('success', 'Google Translate API key updated successfully.');
    }

    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'api_key' => 'required|string',
    //     ]);

    //     $newKey = $request->api_key;

    //     // 1. Save in DB
    //     TranslateApi::setValue('google_translate_key', $newKey);

    //     // 2. Update .env
    //     $this->setEnvironmentValue('GOOGLE_TRANSLATE_KEY', $newKey);

    //     // 3. Clear config cache to apply changes
    //     Artisan::call('config:clear');

    //     return redirect()->route('translate.edit')->with('success', 'Google Translate API key updated successfully.');
    // }

/**
 * Update or add environment variable in .env file.
 */
    // protected function setEnvironmentValue($key, $value)
    // {
    //     $path = base_path('.env');

    //     if (file_exists($path)) {
    //         // Read .env content
    //         $env = file_get_contents($path);

    //         // Replace existing key or add new one
    //         if (strpos($env, $key . '=') !== false) {
    //             $env = preg_replace('/^' . $key . '=.*/m', $key . '=' . $value, $env);
    //         } else {
    //             $env .= "\n" . $key . '=' . $value;
    //         }

    //         file_put_contents($path, $env);
    //     }
    // }
}
