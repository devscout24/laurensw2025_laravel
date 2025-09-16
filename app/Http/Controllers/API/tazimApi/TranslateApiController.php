<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\TranslateApi;
use App\Traits\apiresponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranslateApiController extends Controller
{
    use apiresponse;
    public function translate(Request $request)
    {
        $request->validate([
            'text'   => 'required|string',
            'target' => 'required|string', // e.g. "es", "fr", "bn"
            'source' => 'nullable|string', // optional, default "auto"
        ]);

        // Get API key from DB or fallback to .env
        $apiKey = TranslateApi::getValue('google_translate_key', config('services.google_translate.key'));

        if (empty($apiKey)) {
            return $this->error([], 'Google Translate API key not configured.', 500);
        }

        $text   = $request->text;
        $target = $request->target;
        $source = $request->source ?? 'auto';

        try {
            $response = Http::get("https://translation.googleapis.com/language/translate/v2", [
                'q'      => $text,
                'target' => $target,
                'source' => $source,
                'format' => 'text',
                'key'    => $apiKey, // Laravel will append as query param
            ]);

            if ($response->failed()) {
                return $this->error($response->json(), 'Translation request failed', 500);
            }

            $data = $response->json();

            $result = [
                'translatedText' => $data['data']['translations'][0]['translatedText'] ?? null,
                'detectedSource' => $data['data']['translations'][0]['detectedSourceLanguage'] ?? $source,
            ];

            return $this->success($result, 'Success', 200);

        } catch (\Exception $e) {
            return $this->error([], 'Exception: ' . $e->getMessage(), 500);
        }
    }

}
